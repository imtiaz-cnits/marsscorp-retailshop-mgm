import fs from 'fs';
import path from 'path';

function getAllPhpFiles(dir) {
    let results = [];
    if (!fs.existsSync(dir)) return results;
    const list = fs.readdirSync(dir);
    list.forEach(file => {
        const filePath = path.join(dir, file);
        const stat = fs.statSync(filePath);
        if (stat && stat.isDirectory()) {
            results = results.concat(getAllPhpFiles(filePath));
        } else if (file.endsWith('.php')) {
            results.push(filePath);
        }
    });
    return results;
}

const targetDirs = ['app', 'routes', 'resources/views'];
let totalFiles = 0;
let modifiedFiles = [];

targetDirs.forEach(dirName => {
    const files = getAllPhpFiles(path.resolve(dirName));
    files.forEach(filePath => {
        totalFiles++;
        let content = fs.readFileSync(filePath, 'utf8');
        let originalContent = content;

        // 1. Replace layout. / layout/ -> layouts. / layouts/
        content = content.replace(/(['"])layout\.([^'"]+)\1/g, "$1layouts.$2$1");
        content = content.replace(/(['"])layout\/([^'"]+)\1/g, "$1layouts/$2$1");

        // 2. Replace email. / email/ -> emails. / emails/
        content = content.replace(/(['"])email\.([^'"]+)\1/g, "$1emails.$2$1");
        content = content.replace(/(['"])email\/([^'"]+)\1/g, "$1emails/$2$1");

        // 3. Replace components.front-end. / components/front-end/ -> frontend. / frontend/
        content = content.replace(/(['"])components\.front-end\.([^'"]+)\1/g, (match, q, rest) => {
            return `${q}frontend.${rest.toLowerCase()}${q}`;
        });
        content = content.replace(/(['"])components\/front-end\/([^'"]+)\1/g, (match, q, rest) => {
            return `${q}frontend/${rest.toLowerCase()}${q}`;
        });

        // 4. Replace components.back-end. / components/back-end/ -> backend. / backend/
        // Converts the first directory after backend to lowercase to match folder rename
        content = content.replace(/(['"])components\.back-end\.([^'"]+)\1/g, (match, q, rest) => {
            const parts = rest.split('.');
            // Lowercase folder names in the path, keeping blade file names intact
            // e.g. Category.category-list -> category.category-list
            // Pos.pos-page -> pos.pos-page
            // Supplier.supplier-due.supplier-due-list -> supplier.supplier-due.supplier-due-list
            const lowerParts = parts.map((p, idx) => {
                // If it's a folder segment or filename
                return p.toLowerCase();
            });
            return `${q}backend.${lowerParts.join('.')}${q}`;
        });

        content = content.replace(/(['"])components\/back-end\/([^'"]+)\1/g, (match, q, rest) => {
            const parts = rest.split('/');
            const lowerParts = parts.map((p) => p.toLowerCase());
            return `${q}backend/${lowerParts.join('/')}${q}`;
        });

        if (content !== originalContent) {
            fs.writeFileSync(filePath, content, 'utf8');
            modifiedFiles.push(filePath);
        }
    });
});

console.log(`Scanned ${totalFiles} PHP files.`);
console.log(`Updated view references in ${modifiedFiles.length} files:`);
modifiedFiles.forEach(f => console.log(' - ' + path.relative(process.cwd(), f)));
