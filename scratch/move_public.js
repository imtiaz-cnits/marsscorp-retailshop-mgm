import fs from 'fs';
import path from 'path';

const publicDir = path.resolve('public');

// 1. Rename public/back-end -> public/backend
const oldBackEnd = path.join(publicDir, 'back-end');
const newBackend = path.join(publicDir, 'backend');

if (fs.existsSync(oldBackEnd)) {
    fs.renameSync(oldBackEnd, newBackend);
    console.log('Renamed public/back-end -> public/backend');
} else {
    console.log('public/back-end does not exist or already renamed');
}

// 2. Rename uploads subfolders to standard kebab-case
const uploadsDir = path.join(publicDir, 'uploads');
if (fs.existsSync(uploadsDir)) {
    const uploadRenames = [
        { oldName: 'brand_img', newName: 'brand-img' },
        { oldName: 'category_image', newName: 'category-img' },
        { oldName: 'Product-img', newName: 'product-img' },
        { oldName: 'Supplier-images', newName: 'supplier-img' },
        { oldName: 'cust-img', newName: 'customer-img' }
    ];

    uploadRenames.forEach(({ oldName, newName }) => {
        const src = path.join(uploadsDir, oldName);
        const dest = path.join(uploadsDir, newName);
        if (fs.existsSync(src) && src !== dest) {
            fs.renameSync(src, dest);
            console.log(`Renamed upload folder: uploads/${oldName} -> uploads/${newName}`);
        } else if (!fs.existsSync(dest)) {
            fs.mkdirSync(dest, { recursive: true });
            console.log(`Created upload folder: uploads/${newName}`);
        }
    });
}
