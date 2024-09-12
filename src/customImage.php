<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<style>
    #progressContainer {
        display: none;
        /* Initially hidden */
        margin-top: 10px;
        background: #f3f3f3;
        border-radius: 5px;
        overflow: hidden;
    }

    #progressBar {
        width: 0;
        height: 20px;
        background: #4caf50;
        color: white;
        text-align: center;
        line-height: 20px;
        border-radius: 5px;
    }

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

    .image-border {
        height: 23rem;
        overflow: hidden;
    }

    #selectedImage {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    @keyframes shimmer {
        0% {
            background-position: -100% 0;
        }

        100% {
            background-position: 100% 0;
        }
    }

    .shimmer {
        background: linear-gradient(90deg, rgba(255, 255, 255, 0.1) 25%, rgba(255, 255, 255, 0.3) 50%, rgba(255, 255, 255, 0.1) 75%);
        background-size: 200% 100%;
        animation: shimmer 2s infinite;
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 10; /* Ensure shimmer is above the image */
        opacity: 0.8; /* Slight transparency so image is visible */
        border-radius: inherit; /* Match the border radius of the container */
    }
    #imageContainer{
        position: relative;
    }
</style>
<script>
    function toggleMenu() {
        const mobileMenu = document.getElementById('mobileMenu');
        mobileMenu.classList.toggle('open');
    }
</script>

<body class="bg-gray-900 text-gray-200">
    <!-- Navbar -->
    <nav class="bg-gray-800 p-4">
        <div class="container mx-auto flex justify-between items-center">
            <a href="#" class="text-2xl font-bold text-blue-500">Joe Converter</a>
            <div class="hidden md:flex space-x-4">
                <a href="#" class="hover:text-blue-400">Home</a>
                <a href="#Features" class="hover:text-blue-400">Features</a>
                <a href="#" class="hover:text-blue-400">Pricing</a>
                <a href="#" class="hover:text-blue-400">Contact</a>
                <a href="#" class="hover:text-blue-400">Login</a>
            </div>
            <!-- Hamburger Icon for Mobile -->
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
    <main class="p-5 h-full">
        <h2 class="text-2xl text-blue-500">Convert Image to any format</h2>
        <form method="post" id="customImageForm">
            <section class="grid grid-cols-1 md:grid-cols-3 w-full gap-6">
                <div class="mt-6 border-4  border-gray-600 p-6 rounded-lg  image-border flex justify-center items-center md:col-span-2 " id="imageContainer">
                    <input type="file" name="image" id="image" hidden>
                    <label for="image" class="p-4 bg-blue-700 text-white rounded-2xl cursor-pointer">
                        Import Image
                    </label>
                    <img id="selectedImage" class="hidden  inset-0  object-cover" />
                    <!-- Shimmer overlay -->
                    <div id="shimmerOverlay" class="hidden shimmer"></div>
                </div>
                <div>
                    <h3 class="text-2xl text-blue-500">Select format</h3>
                    <div class="relative inline-block w-full mt-2">
                        <select name="outputFormat" class="block appearance-none w-full bg-white border text-gray-600 border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                            <option value="JPEG">JPEG</option>
                            <option value="PNG">PNG</option>
                            <option value="GIF">GIF</option>
                            <option value="BMP">BMP</option>
                            <option value="TIFF">TIFF</option>
                            <option value="WEBP">WEBP</option>
                            <option value="SVG">SVG</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 011.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                            </svg>
                        </div>
                    </div>
                    <button id="submitImage" type="button" class="p-3 rounded-2xl w-full flex justify-center  text-center bg-blue-600 text-white my-5  cursor-pointer">
                        Convert
                    </button>
                    <div id="spinner" class="flex items-center justify-center h-12 hidden">
                        <h2 class="text-2xl text-blue-500">Converting....</h2>
                        <div class="animate-spin rounded-full h-12 w-12 border-t-4 border-blue-500"></div>
                    </div>
                    <h2 class="text-2xl text-red-500 px-4" id="pageCount"></h2>
                    <div id="downloadLink" class="mx-4 w-auto flex items-center justify-center my-5 hidden bg-blue-700 text-white py-3 px-6 rounded-lg hover:bg-blue-600">
                        <a href="#" id="convertedFileLink"  download>Download Converted File</a>
                    </div>
                </div>
            </section>
        </form>

    </main>




    <script src="../javascript/customImage.js"></script>
    <!-- <script src="../javascript/disable_clicks.js"></script> -->
</body>

</html>