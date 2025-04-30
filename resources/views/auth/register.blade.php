<!DOCTYPE html>
<html>
<head>
    <title>Products</title>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="w-full max-w-sm p-6 bg-white rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold text-center text-gray-700 mb-4">Register</h2>

        @if ($errors->any())
            <div class="mb-4 text-red-500">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login.submit') }}">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-sm text-gray-600">Full Name</label>
                <input type="text" id="name" name="name" class="w-full px-4 py-2 border rounded-md" required>
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm text-gray-600">Email</label>
                <input type="email" id="email" name="email" class="w-full px-4 py-2 border rounded-md" required>
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm text-gray-600">Password</label>
                <input type="password" id="password" name="password" class="w-full px-4 py-2 border rounded-md" required>
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="block text-sm text-gray-600">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="w-full px-4 py-2 border rounded-md" required>
            </div>

            <button type="submit" class="w-full px-4 py-2 text-white bg-green-500 rounded-md hover:bg-green-600">Register</button>
        </form>
    </div>
</body>
</html>
