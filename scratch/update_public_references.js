import fs from 'fs';
import path from 'path';

function getAllFiles(dir, extensions = ['.php', '.js', '.css', '.json']) {
    let results = [];
    if (!fs.existsSync(dir)) return results;
    const list = fs.readdirSync(dir);
    list.forEach(file => {
        const filePath = path.join(dir, file);
        const stat = fs.statSync(filePath);
        if (stat && stat.isDirectory()) {
            results = results.concat(getAllFiles(filePath, extensions));
        } else if (extensions.some(ext => file.endsWith(ext))) {
            results.push(filePath);
        }
    });
    return results;
}

const targetFiles = [
    ...getAllFiles(path.resolve('app')),
    ...getAllFiles(path.resolve('resources')),
    ...getAllFiles(path.resolve('routes')),
    path.resolve('tailwind.config.js')
];

let modifiedCount = 0;

targetFiles.forEach(filePath => {
    if (!fs.existsSync(filePath)) return;
    let content = fs.readFileSync(filePath, 'utf8');
    let original = content;

    // 1. back-end -> backend in asset paths & tailwind config
    content = content.replace(/public\/back-end/g, 'public/backend');
    content = content.replace(/back-end\/assets/g, 'backend/assets');
    content = content.replace(/asset\(['"]back-end\//g, (m) => m.replace('back-end', 'backend'));

    // 2. Upload folder path standardizations
    content = content.replace(/uploads\/brand_img/g, 'uploads/brand-img');
    content = content.replace(/uploads\/category_image/g, 'uploads/category-img');
    content = content.replace(/uploads\/Product-img/g, 'uploads/product-img');
    content = content.replace(/uploads\/Supplier-images/g, 'uploads/supplier-img');
    content = content.replace(/uploads\/cust-img/g, 'uploads/customer-img');

    if (content !== original) {
        fs.writeFileSync(filePath, content, 'utf8');
        modifiedCount++;
        console.log('Updated: ' + path.relative(process.cwd(), filePath));
    }
});

console.log(`Successfully updated public/asset references in ${modifiedCount} files.`);
