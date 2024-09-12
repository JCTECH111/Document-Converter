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
        display: none; /* Initially hidden */
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
        max-height: 0; /* Initially collapsed */
        opacity: 0;
        overflow: hidden; /* Hide overflowing content */
    }

    /* When the menu is visible */
    #mobileMenu.open {
        max-height: 500px; /* Adjust based on content height */
        opacity: 1;
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
        <a href="#" class="text-2xl font-bold text-blue-500">PDF Converter</a>
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
<main class="p-8">
    <h2 class="text-2xl text-blue-500">Convert Word document to a pdf format</h2>
    <div class="mt-6 border-4 border-dashed border-gray-600 p-6 rounded-lg">
        <form action="#" id="form" method="POST" enctype="multipart/form-data" class="space-y-4">
            <div class="flex justify-center">
                <div class="flex items-center justify-center w-full">
                    <label id="dropArea" class="flex flex-col items-center justify-center w-full h-32 border-4 border-dashed border-blue-500 hover:bg-gray-800 hover:border-blue-700 cursor-pointer">
                        <!-- Font Awesome Icon -->
                        <i class="fas fa-cloud-upload-alt text-blue-500 text-4xl"></i>
                        <span class="text-blue-500 mt-2">Drag and Drop or Click to Upload</span>
                        <input id="fileInput" type="file" name="file" class="hidden">
                    </label>
                </div>
            </div>
        </form>
    </div>
    <div id="progressContainer">
        <div id="progressBar">0%</div>
    </div>

</main>
<div id="spinner" class="flex items-center justify-center h-12 hidden">
    <h2 class="text-2xl text-blue-500">Converting....</h2>
    <div class="animate-spin rounded-full h-12 w-12 border-t-4 border-blue-500"></div>
  </div>
  <h2 class="text-2xl text-blue-500 px-4 py-2" id="pageCount"></h2>
  <div id="downloadLink" class="mx-4 w-auto flex items-center justify-center hidden bg-blue-700 text-white py-3 px-6 rounded-lg hover:bg-blue-600">
    <a href="#" id="convertedFileLink" class="" download>Download Converted File</a>
</div>




<script src="../javascript/word-to-pdf.js"></script>
<script src="../javascript/disable_clicks.js"></script>
</body>
</html>