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

const viewsDir = path.resolve('resources/views');
const targetDirs = ['app', 'routes', 'resources/views'];
let missingViews = [];
let totalChecked = 0;

const viewRegexes = [
    /@extends\(['"]([^'"]+)['"]\)/g,
    /@include\(['"]([^'"]+)['"]\)/g,
    /return view\(['"]([^'"]+)['"]/g,
    /Route::view\(['"][^'"]+['"]\s*,\s*['"]([^'"]+)['"]\)/g,
    /view:\s*['"]([^'"]+)['"]/g
];

targetDirs.forEach(dirName => {
    const files = getAllPhpFiles(path.resolve(dirName));
    files.forEach(filePath => {
        const content = fs.readFileSync(filePath, 'utf8');
        
        viewRegexes.forEach(regex => {
            let match;
            while ((match = regex.exec(content)) !== null) {
                const viewName = match[1];
                if (viewName === 'view.name') continue; // Example placeholder
                totalChecked++;

                // Convert dot notation viewName to file path
                const relativeViewPath = viewName.replace(/\./g, '/') + '.blade.php';
                const fullViewPath = path.join(viewsDir, relativeViewPath);

                if (!fs.existsSync(fullViewPath)) {
                    missingViews.push({
                        sourceFile: path.relative(process.cwd(), filePath),
                        viewName: viewName,
                        expectedPath: path.relative(process.cwd(), fullViewPath)
                    });
                }
            }
        });
    });
});

console.log(`Total view references checked: ${totalChecked}`);
if (missingViews.length === 0) {
    console.log('SUCCESS: All view references exist on disk!');
} else {
    console.error(`WARNING: Found ${missingViews.length} missing view references:`);
    missingViews.forEach(m => {
        console.error(` - In ${m.sourceFile}: View "${m.viewName}" expected at ${m.expectedPath}`);
    });
}
