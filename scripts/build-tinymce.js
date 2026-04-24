const fs = require('fs');
const path = require('path');

// Source: node_modules/tinymce
const tinymceSrc = path.join(__dirname, '..', 'node_modules', 'tinymce');

// Destination: public/js/lib/tinymce
const tinymceDest = path.join(__dirname, '..', 'public', 'js', 'lib', 'tinymce');

// Remove old version
if (fs.existsSync(tinymceDest)) {
    fs.rmSync(tinymceDest, { recursive: true, force: true });
}

// Copy new version
fs.cpSync(tinymceSrc, tinymceDest, { recursive: true });

// Remove unnecessary files (examples, changelog, etc.)
const filesToRemove = [
    path.join(tinymceDest, 'README.md'),
    path.join(tinymceDest, 'CHANGELOG.md'),
    path.join(tinymceDest, 'composer.json'),
    path.join(tinymceDest, 'package.json'),
];

filesToRemove.forEach(file => {
    if (fs.existsSync(file)) {
        fs.unlinkSync(file);
    }
});

console.log('✓ TinyMCE successfully built and copied to public/js/lib/tinymce/');
