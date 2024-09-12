<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive URL Modal with Animation</title>
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
        width: 100%;
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
<main class="p-8 flex flex-col gap-3 items-center justify-center">
    <h2 class="text-2xl text-blue-500">Convert Html/Web Page to a pdf format</h2>
    <!-- Button to trigger the modal -->
    <button id="openModalBtn" class="bg-blue-700 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-all duration-300">
        Open Modal
    </button>

    <form  method="post" id="formUrl">
        <!-- Modal Background -->
    <div id="urlModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hidden transition-opacity duration-300 ease-out opacity-0 px-4">
        <!-- Modal Content -->
        <div class="bg-white p-6 rounded-lg shadow-lg  w-full max-w-md transform transition-transform duration-500 ease-out scale-95 opacity-0">
            <h2 class="text-2xl font-semibold mb-4">Enter Website URL</h2>
            
            <label for="websiteUrl" class="block text-sm font-medium text-gray-700">URL:</label>
            <input type="url" id="websiteUrl" name="websiteUrl" placeholder="https://example.com" 
                   class="w-full px-4 py-2 text-blue-500 mt-2 mb-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            
            <div class="flex justify-end">
                <button type="button" id="closeModalBtn" class="mr-2 bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-all duration-300">
                    Cancel
                </button>
                <button type="submit" class="bg-blue-700 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-all duration-300">
                    Submit
                </button>
            </div>
        </div>
    </div>
    </form>
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




<script src="../javascript/html-to-pdf.js"></script>

    <script>
        // JavaScript to handle modal visibility and animations
        const openModalBtn = document.getElementById('openModalBtn');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const urlModal = document.getElementById('urlModal');
        const modalContent = urlModal.querySelector('div');

        openModalBtn.addEventListener('click', () => {
            urlModal.classList.remove('hidden');
            setTimeout(() => {
                urlModal.classList.remove('opacity-0');
                modalContent.classList.remove('scale-95', 'opacity-0');
            }, 10); // Add small delay for animation
        });

        closeModalBtn.addEventListener('click', () => {
            urlModal.classList.add('opacity-0');
            modalContent.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                urlModal.classList.add('hidden');
            }, 300); // Match transition duration
        });

        // Close the modal when clicking outside of the modal content
        window.addEventListener('click', (e) => {
            if (e.target === urlModal) {
                closeModalBtn.click();
            }
        });
    </script>
    <script src="../javascript/disable_clicks.js"></script>
</body>
</html>
