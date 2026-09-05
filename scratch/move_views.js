import fs from 'fs';
import path from 'path';

const viewsDir = path.resolve('resources/views');

// 1. Rename layout to layouts
const oldLayout = path.join(viewsDir, 'layout');
const newLayout = path.join(viewsDir, 'layouts');
if (fs.existsSync(oldLayout)) {
    fs.renameSync(oldLayout, newLayout);
    console.log('Renamed layout -> layouts');
} else {
    console.log('layout folder does not exist or already renamed');
}

// 2. Rename email to emails
const oldEmail = path.join(viewsDir, 'email');
const newEmail = path.join(viewsDir, 'emails');
if (fs.existsSync(oldEmail)) {
    fs.renameSync(oldEmail, newEmail);
    console.log('Renamed email -> emails');
} else {
    console.log('email folder does not exist or already renamed');
}

// 3. Move components/back-end/* to backend/* (lowercased)
const backEndDir = path.join(viewsDir, 'components', 'back-end');
const backendDir = path.join(viewsDir, 'backend');
if (!fs.existsSync(backendDir)) {
    fs.mkdirSync(backendDir, { recursive: true });
}

if (fs.existsSync(backEndDir)) {
    const items = fs.readdirSync(backEndDir);
    items.forEach(item => {
        const srcPath = path.join(backEndDir, item);
        const lowerItem = item.toLowerCase();
        const destPath = path.join(backendDir, lowerItem);
        fs.renameSync(srcPath, destPath);
        console.log(`Moved backend item: ${item} -> backend/${lowerItem}`);
    });
    try {
        fs.rmdirSync(backEndDir);
        console.log('Removed components/back-end');
    } catch (e) {
        console.log('Note on back-end rmdir:', e.message);
    }
}

// 4. Move components/front-end/* to frontend/*
const frontEndDir = path.join(viewsDir, 'components', 'front-end');
const frontendDir = path.join(viewsDir, 'frontend');
if (!fs.existsSync(frontendDir)) {
    fs.mkdirSync(frontendDir, { recursive: true });
}

if (fs.existsSync(frontEndDir)) {
    const items = fs.readdirSync(frontEndDir);
    items.forEach(item => {
        const srcPath = path.join(frontEndDir, item);
        const lowerItem = item.toLowerCase();
        const destPath = path.join(frontendDir, lowerItem);
        fs.renameSync(srcPath, destPath);
        console.log(`Moved frontend item: ${item} -> frontend/${lowerItem}`);
    });
    try {
        fs.rmdirSync(frontEndDir);
        console.log('Removed components/front-end');
    } catch (e) {
        console.log('Note on front-end rmdir:', e.message);
    }
}
