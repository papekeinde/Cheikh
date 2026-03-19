const puppeteer = require('puppeteer');
const path = require('path');

(async () => {
    const browser = await puppeteer.launch({
        headless: 'new',
        defaultViewport: { width: 1440, height: 900 },
        args: ['--no-sandbox']
    });

    const page = await browser.newPage();

    const url = process.argv[2];
    const filename = process.argv[3];

    if (!url || !filename) {
        console.error('Usage: node screenshot.js <url> <filename>');
        process.exit(1);
    }

    const outputPath = path.join(__dirname, 'public', 'images', 'projets', filename);

    try {
        await page.goto(url, { waitUntil: 'networkidle2', timeout: 15000 });
        await new Promise(r => setTimeout(r, 2000));
        await page.screenshot({ path: outputPath, type: 'png' });
        console.log('OK: ' + outputPath);
    } catch (e) {
        console.error('FAIL: ' + url + ' - ' + e.message);
    }

    await browser.close();
})();
