const fs = require('fs');
const path = require('path');

// Configuration - adjust these paths according to your project structure
const config = {
  dependencies: [
    {
      from: 'node_modules/flag-icons/css/flag-icons.min.css',
      to: 'assets/vendor/flag-icons/css/flag-icons.min.css'
    }
    // Add more dependencies as needed
  ],
  // Ensure target directory exists
  createTargetDirs: true
};

// Create directories if they don't exist
function ensureDirectoryExists(filePath) {
  const dirname = path.dirname(filePath);
  if (fs.existsSync(dirname)) {
    return;
  }
  fs.mkdirSync(dirname, { recursive: true });
}

// Copy files
function copyDependencies() {
  config.dependencies.forEach(dep => {
    const sourcePath = path.resolve(dep.from);
    const targetPath = path.resolve(dep.to);

    if (config.createTargetDirs) {
      ensureDirectoryExists(targetPath);
    }

    try {
      fs.copyFileSync(sourcePath, targetPath);
      console.log(`✓ Copied ${dep.from} to ${dep.to}`);
    } catch (error) {
      console.error(`✗ Failed to copy ${dep.from}: ${error.message}`);
    }
  });
}

copyDependencies();