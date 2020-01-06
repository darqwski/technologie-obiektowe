const { lstatSync, readdirSync, readdir }  = require('fs');

readdir('E:', (err, files) => {
    files.forEach(file => {
        console.log(file);
    });
});