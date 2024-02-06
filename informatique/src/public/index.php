<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EVENT - IT</title>
    <link href="style.css" rel="stylesheet">
</head>

<body class="flex flex-col items-center h-screen">
    <header class="flex p-4 flex-row items-center w-full bg-teal-500 shadow-md text-white">
        <h1 class="text-3xl font-bold">EVENT - IT</h1>
        <div class="ml-auto flex flex-row items-center font-bold text-sm space-x-5">
            <p class="text-sm">Se connecter</p>
            <p class="p-4 bg-white text-teal-500 rounded-xl">S'inscrire</p>
        </div>
    </header>

    <div class="flex flex-col min-h-screen w-full">
        <section class="relative h-[600px] md:h-[700px] lg:h-[800px]">
            <!-- <img src="/placeholder.svg" alt="Background" class="absolute inset-0 object-cover w-full h-full" /> -->
            <div class="absolute inset-0 "></div>
            <div class="relative z-10 flex flex-col items-center justify-center px-4 text-center h-[600px]">
                <h1 class="text-4xl font-bold md:text-5xl lg:text-6xl">EVENT IT</h1>
                <p class="mt-4 text-lg  md:text-xl lg:text-2xl">
                    Experience the best sound quality with our products.
                </p>
                <a class="inline-flex mt-8 px-8 py-3 text-sm font-medium text-white bg-teal-500 rounded-md hover:bg-teal-500" href="#">
                    Explore Products
                </a>
            </div>
        </section>
        <section class="px-4 py-12 md:px-6 md:py-24 lg:px-8 lg:py-32 bg-teal-500">
            <h2 class="text-3xl font-bold text-white md:text-4xl lg:text-5xl">Featured Products</h2>
            <div class="grid mt-8 gap-6 md:grid-cols-2 lg:grid-cols-3">
                <div class="flex flex-col items-center text-center">
                    <img src="/placeholder.svg" alt="Product 1" class="w-full h-64 object-cover rounded-md" />
                    <h3 class="mt-4 text-lg font-medium text-white">Product 1</h3>
                    <p class="mt-2 text-sm text-white">This is a short description of the product.</p>
                </div>
                <div class="flex flex-col items-center text-center">
                    <img src="/placeholder.svg" alt="Product 2" class="w-full h-64 object-cover rounded-md" />
                    <h3 class="mt-4 text-lg font-medium text-white">Product 2</h3>
                    <p class="mt-2 text-sm text-white">This is a short description of the product.</p>
                </div>
                <div class="flex flex-col items-center text-center">
                    <img src="/placeholder.svg" alt="Product 3" class="w-full h-64 object-cover rounded-md" />
                    <h3 class="mt-4 text-lg font-medium text-white">Product 3</h3>
                    <p class="mt-2 text-sm text-white">This is a short description of the product.</p>
                </div>
            </div>
        </section>
    </div>
</body>

</html>