<!DOCTYPE html>
<html>
<head>
    <title>products</title>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="w-full max-w-sm p-6 bg-white rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold text-center text-gray-700 mb-4">Login</h2>

        @if (session('error'))
            <div class="mb-4 text-red-500">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-4">
                <label for="email" class="block text-sm text-gray-600">Email</label>
                <input type="email" id="email" name="email" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring" required autofocus>
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm text-gray-600">Password</label>
                <input type="password" id="password" name="password" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring" required>
            </div>

            <button type="submit" class="w-full px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600">Login</button>
        </form>
    </div>
</body>
</html>
