<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advanced PDF Converter & Editor</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.5.2/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>
<style>
    /* Apply smooth transition */
    #mobileMenu {
        transition: max-height 0.3s ease-out, opacity 0.3s ease-out;
        max-height: 0;
        /* Initially collapsed */
        opacity: 0;
        overflow: hidden;
        /* Hide overflowing content */
    }

    /* When the menu is visible */
    #mobileMenu.open {
        max-height: 500px;
        /* Adjust based on content height */
        opacity: 1;
    }
</style>
<script>
    function toggleMenu() {
        const mobileMenu = document.getElementById('mobileMenu');
        mobileMenu.classList.toggle('open');
    }
</script>

<body class="bg-gray-900 text-white">
    <!-- Navbar -->
    <nav class="bg-gray-800 p-4">
        <div class="container mx-auto flex justify-between items-center">
            <a href="#" class="text-2xl font-bold text-blue-500">PDF Converter</a>
            <div class="hidden md:flex space-x-4">
                <a href="#" class="hover:text-blue-400">Home</a>
                <a href="#Features" class="hover:text-blue-400">Features</a>
                <a href="#" class="hover:text-blue-400">Pricing</a>
                <a href="#" class="hover:text-blue-400">Contact</a>
                <a href="#" class="hover:text-blue-400">Login</a>
            </div>
            <!-- Hamburger Icon for Mobile -->
            <div class="md:hidden">
                <button onclick="toggleMenu()" class="text-blue-500 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                </button>
            </div>
        </div>
        <!-- Mobile Menu -->
        <div id="mobileMenu" class="md:hidden">
            <div class="bg-gray-800 space-y-2 py-2">
                <a href="#" class="block px-4 py-2 hover:bg-gray-700">Home</a>
                <a href="#Features" class="block px-4 py-2 hover:bg-gray-700">Features</a>
                <a href="#" class="block px-4 py-2 hover:bg-gray-700">Pricing</a>
                <a href="#" class="block px-4 py-2 hover:bg-gray-700">Contact</a>
                <a href="#" class="block px-4 py-2 hover:bg-gray-700">Login</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="text-center py-16 md:py-20 bg-gray-900">
        <div class="container mx-auto px-4">
            <h1 class="text-4xl md:text-6xl font-bold text-blue-500 mb-6">Convert & Edit PDF Files Easily</h1>
            <p class="text-lg md:text-xl text-gray-400 mb-8">Effortlessly convert, edit, and manage your PDFs with our advanced tools.</p>
            <a href="#" class="bg-blue-700 text-white py-3 px-6 rounded-lg hover:bg-blue-600">Get Started</a>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-12 md:py-16 bg-gray-800">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold text-blue-500 mb-12">Our Tools For documents</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6" id="Features">
                <div class="bg-gray-700 p-6 md:p-8 rounded-lg hover:bg-gray-600 transition">
                    <div class="flex items-center justify-center mb-4">
                        <i class="fas fa-file-pdf text-7xl text-red-500 mx-4"></i>
                        <i class="fas fa-exchange-alt text-3xl text-gray-400 mx-4"></i>
                        <i class="fas fa-file-word text-7xl text-blue-500 mx-4"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">PDF to Word</h3>
                    <p class="text-gray-400 mb-4">Convert your PDFs into editable Word documents.</p>
                    <a href="./src/PdfToWord.php" class="text-blue-400 hover:text-blue-500">Try it Now</a>
                </div>
                <div class="bg-gray-700 p-6 md:p-8 rounded-lg hover:bg-gray-600 transition">
                    <div class="flex items-center justify-center mb-4">
                        <i class="fas fa-file-pdf text-7xl text-red-500 mx-4"></i>
                        <i class="fas fa-exchange-alt text-3xl text-gray-400 mx-4"></i>
                        <i class="fas fa-file-excel text-7xl text-green-500 mx-4"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">PDF to Excel</h3>
                    <p class="text-gray-400 mb-4">Easily extract data from PDF to Excel format.</p>
                    <a href="./src/pdfToExcel.php" class="text-blue-400 hover:text-blue-500">Try it Now</a>
                </div>
                <div class="bg-gray-700 p-6 md:p-8 rounded-lg hover:bg-gray-600 transition">
                    <div class="flex items-center justify-center mb-4">
                        <i class="fas fa-file-pdf text-7xl text-red-500 mx-4"></i>
                        <i class="fas fa-exchange-alt text-3xl text-gray-400 mx-4"></i>
                        <i class="fas fa-file-image text-7xl text-green-500 mx-4"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">PDF to Image</h3>
                    <p class="text-gray-400 mb-4">Convert PDF pages to high-quality images.</p>
                    <a href="./src/pdfToImage.php" class="text-blue-400 hover:text-blue-500">Try it Now</a>
                </div>
                <div class="bg-gray-700 p-6 md:p-8 rounded-lg hover:bg-gray-600 transition">
                    <div class="flex items-center justify-center mb-4">
                        <i class="fas fa-file-pdf text-7xl text-red-500 mx-4"></i>
                        <i class="fas fa-exchange-alt text-3xl text-gray-400 mx-4"></i>
                        <i class="fas fa-file-code text-7xl text-red-500 mx-4"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">PDF to Html</h3>
                    <p class="text-gray-400 mb-4">Convert your PDFs into editable Word documents.</p>
                    <a href="./src/pdfToHtml.php" class="text-blue-400 hover:text-blue-500">Try it Now</a>
                </div>
                <div class="bg-gray-700 p-6 md:p-8 rounded-lg hover:bg-gray-600 transition">
                    <!-- Icons Container -->
                    <div class="flex items-center justify-center mb-4">
                        <i class="fas fa-file-word text-7xl text-blue-500 mx-4"></i>
                        <i class="fas fa-exchange-alt text-3xl text-gray-400 mx-4"></i>
                        <i class="fas fa-file-pdf text-7xl text-red-500 mx-4"></i>
                    </div>

                    <h3 class="text-2xl font-bold mb-4">Word to PDF</h3>
                    <p class="text-gray-400 mb-4">Easily extract data from editable Word documents to PDF format.</p>
                    <a href="./src/wordToPdf.php" class="text-blue-400 hover:text-blue-500">Try it Now</a>
                </div>

                <div class="bg-gray-700 p-6 md:p-8 rounded-lg hover:bg-gray-600 transition">
                    <div class="flex items-center justify-center mb-4">
                        <i class="fas fa-file-excel text-7xl text-green-500 mx-4"></i>
                        <i class="fas fa-exchange-alt text-3xl text-gray-400 mx-4"></i>
                        <i class="fas fa-file-pdf text-7xl text-red-500 mx-4"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Excel to Pdf</h3>
                    <p class="text-gray-400 mb-4">Convert documents from Excel to Pdf format.</p>
                    <a href="./src/excelToPDf.php" class="text-blue-400 hover:text-blue-500">Try it Now</a>
                </div>
                <div class="bg-gray-700 p-6 md:p-8 rounded-lg hover:bg-gray-600 transition">
                    <div class="flex items-center justify-center mb-4">
                        <i class="fas fa-file-image text-7xl text-green-500 mx-4"></i>
                        <i class="fas fa-exchange-alt text-3xl text-gray-400 mx-4"></i>
                        <i class="fas fa-file-pdf text-7xl text-red-500 mx-4"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Image to Pdf</h3>
                    <p class="text-gray-400 mb-4">Convert Image to Pdf documents.</p>
                    <a href="./src/imageToPdf.php" class="text-blue-400 hover:text-blue-500">Try it Now</a>
                </div>
                <div class="bg-gray-700 p-6 md:p-8 rounded-lg hover:bg-gray-600 transition">
                    <div class="flex items-center justify-center mb-4">
                        <i class="fas fa-file-code text-7xl text-green-500 mx-4"></i>
                        <i class="fas fa-exchange-alt text-3xl text-gray-400 mx-4"></i>
                        <i class="fas fa-file-pdf text-7xl text-red-500 mx-4"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Html to Pdf</h3>
                    <p class="text-gray-400 mb-4">Convert Web contents to a PdfDocument.</p>
                    <a href="./src/htmlToPdf.php" class="text-blue-400 hover:text-blue-500">Try it Now</a>
                </div>
                <div class="bg-gray-700 p-6 md:p-8 rounded-lg hover:bg-gray-600 transition">
                    <div class="flex items-center justify-center mb-4">
                        <i class="fas fa-file-pdf text-7xl text-red-500 mx-4"></i>
                        <i class="fas fa-exchange-alt text-3xl text-gray-400 mx-4"></i>
                        <i class="fas fa-lock text-7xl text-white mx-4"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Secure Pdf</h3>
                    <p class="text-gray-400 mb-4">Protect PDF files with a password. Encrypt PDF documents to prevent unauthorized access.</p>
                    <a href="./src/lockPdf.php" class="text-blue-400 hover:text-blue-500">Try it Now</a>
                </div>

                <!-- Add more tool cards as needed -->
            </div>
        </div>
    </section>
    <section class="py-12 md:py-16 my-7 bg-gray-800">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold text-blue-500 mb-12">Our Tools for Images</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6" id="Features">
                <div class="bg-gray-700 p-6 md:p-8 rounded-lg hover:bg-gray-600 transition">
                    <div class="flex items-center justify-center mb-4">
                        <img src="./assets/jpeg_icon.png" alt="jpeg Logo" width="90">
                        <i class="fas fa-exchange-alt text-3xl text-gray-400 mx-4"></i>
                        <img src="./assets/png_icon.png" alt="png Logo" width="90">
                    </div>
                    <h3 class="text-2xl font-bold mb-4">JPEG/JPG to PNG</h3>
                    <p class="text-gray-400 mb-4">Convert your JPEG/JPG image format  to PNG image format.</p>
                    <a href="./src/JavascriptToTypescript.php" class="text-blue-400 hover:text-blue-500">Try it Now</a>
                </div>
                <div class="bg-gray-700 p-6 md:p-8 rounded-lg hover:bg-gray-600 transition">
                    <div class="flex items-center justify-center mb-4">
                        <img src="./assets/gif_icon.png" alt="gif Logo" width="90">
                        <i class="fas fa-exchange-alt text-3xl text-gray-400 mx-4"></i>
                        <img src="./assets/bmp_icon.png" alt="bmp Logo" width="90">
                    </div>
                    <h3 class="text-2xl font-bold mb-4">GIF To BMP</h3>
                    <p class="text-gray-400 mb-4">Convert your GIF image format  to BMP image format.</p>
                    <a href="./src/JavascriptToTypescript.php" class="text-blue-400 hover:text-blue-500">Try it Now</a>
                </div>
                <div class="bg-gray-700 p-6 md:p-8 rounded-lg hover:bg-gray-600 transition">
                    <div class="flex items-center justify-center mb-4">
                        <img src="./assets/tiff_icon.png" alt="tiff Logo" width="90">
                        <i class="fas fa-exchange-alt text-3xl text-gray-400 mx-4"></i>
                        <img src="./assets/webp_icon.png" alt="webp Logo" width="90">
                    </div>
                    <h3 class="text-2xl font-bold mb-4">TIFF To WEBP</h3>
                    <p class="text-gray-400 mb-4">Convert your TIFF image format  to WEBP image format.</p>
                    <a href="./src/JavascriptToTypescript.php" class="text-blue-400 hover:text-blue-500">Try it Now</a>
                </div>
                <div class="bg-gray-700 p-6 md:p-8 rounded-lg hover:bg-gray-600 transition">
                    <div class="flex items-center justify-center mb-4">
                        <img src="./assets/svg_icon.png" alt="svg Logo" width="90">
                        <i class="fas fa-exchange-alt text-3xl text-gray-400 mx-4"></i>
                        <img src="./assets/png_icon.png" alt="png Logo" width="90">
                    </div>
                    <h3 class="text-2xl font-bold mb-4">SVG To PNG</h3>
                    <p class="text-gray-400 mb-4">Convert your SVG image format  to PNG image format.</p>
                    <a href="./src/JavascriptToTypescript.php" class="text-blue-400 hover:text-blue-500">Try it Now</a>
                </div>
                <div class="bg-gray-700 p-6 md:p-8 rounded-lg hover:bg-gray-600 transition">
                    <div class="flex items-center justify-center mb-4">
                        <i class="fas fa-cog text-8xl text-gray-400 mx-4"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Custom</h3>
                    <p class="text-gray-400 mb-4">Convert your image To any Image format.</p>
                    <a href="./src/customImage.php" class="text-blue-400 hover:text-blue-500">Try it Now</a>
                </div>
            </div>
        </div>
    </section>
    <section class="py-12 md:py-16 my-7 bg-gray-800">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold text-blue-500 mb-12">Our Tools for Programming files</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6" id="Features">
                <div class="bg-gray-700 p-6 md:p-8 rounded-lg hover:bg-gray-600 transition">
                    <div class="flex items-center justify-center mb-4">
                        <i class="fa-brands fa-js text-7xl text-yellow-500 mx-4"></i>
                        <i class="fas fa-exchange-alt text-3xl text-gray-400 mx-4"></i>
                        <img src="https://cdn.worldvectorlogo.com/logos/typescript.svg" alt="TypeScript Logo" width="70">
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Javascript to Typescript</h3>
                    <p class="text-gray-400 mb-4">Convert your Javascript file to typescript.</p>
                    <a href="./src/JavascriptToTypescript.php" class="text-blue-400 hover:text-blue-500">Try it Now</a>
                </div>
                <div class="bg-gray-700 p-6 md:p-8 rounded-lg hover:bg-gray-600 transition">
                    <div class="flex items-center justify-center mb-4">
                        <i class="fa-brands fa-html5 text-7xl text-yellow-500 mx-4"></i>
                        <i class="fas fa-exchange-alt text-3xl text-gray-400 mx-4"></i>
                        <img src="./asset/icons8-xml-64.png" alt="XML Logo" width="80">
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Html to Javafx Fxml</h3>
                    <p class="text-gray-400 mb-4">Convert your Html file to a  XML-based language designed to build the user interface for JavaFX applications</p>
                    <a href="./src/HtmlToXml.php" class="text-blue-400 hover:text-blue-500">Try it Now</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section class="py-16 md:py-20 bg-gray-900">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold text-blue-500 mb-6">Ready to Start Converting?</h2>
            <p class="text-lg md:text-xl text-gray-400 mb-8">Experience seamless PDF conversion and editing with our all-in-one solution.</p>
            <a href="#" class="bg-blue-700 text-white py-3 px-6 rounded-lg hover:bg-blue-600">Start Now</a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 p-4 text-center">
        <p class="text-gray-400">&copy; 2024 Advanced PDF Converter & Editor. All rights reserved. Developed by JoeCode</p>
    </footer>
    <script src="./javascript/disable_clicks.js"></script>
</body>

</html>