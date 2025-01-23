var glob = require("glob");
const imagemin = require('imagemin');
const imageminWebp = require('imagemin-webp');
var outputFolder = "C:\\Users\\Leo\\Desktop\\Laravel Projects\\cruise\\public\\webp", // Output folder
    Images = glob.sync("public/images/**/*.{jpg,png}"),
    JPEGImages = glob.sync("public/images/**/*.jpg");


console.log(Images);
imagemin(Images, 'public/webp', {
    use: [
        imageminWebp({quality: 80})
    ]
}).then(() => {
    console.log('Images optimized');
});
