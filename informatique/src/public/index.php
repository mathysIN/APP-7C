<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EVENT - IT</title>
    <link href="style.css" rel="stylesheet">
</head>

<body class="flex flex-col items-center h-screen">
    <header class="flex p-4 flex-row items-center w-full bg-teal-200 rounded-lg shadow-md text-white">
        <h1 class="text-3xl font-bold">EVENT - IT</h1>
	<div class="ml-auto flex flex-row items-center font-bold text-sm space-x-5">
	    <p class="text-sm">Se connecter</p>
            <p class="p-4 bg-white text-teal-200 rounded-xl">S'inscrire</p>
        </div>
    </header>
    <div>
    <div class="max-w-md mx-auto p-6">
        <form>
            <div class="mb-4">
                <label for="email" class="block text-teal-800">Email</label>
                <input type="email" id="email" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:border-teal-500">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-teal-800">Password</label>
                <input type="password" id="password" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:border-teal-500">
            </div>
            <button type="submit" class="w-full bg-teal-500 text-white py-2 px-4 rounded-xl hover:bg-teal-600 focus:outline-none focus:ring focus:border-teal-500">Login</button>
        </form>
        <p class="mt-4 text-center text-teal-800">Create an account</p>
    </div>	

    </div>
</body>

</html>

