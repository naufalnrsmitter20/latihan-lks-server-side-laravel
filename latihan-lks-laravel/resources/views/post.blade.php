<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
  @vite('resources/css/app.css')
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">
  <title>Document</title>
</head>

<body>
  <div class="grid justify-center w-screen grid-cols-1 gap-4 mt-9">
    <h1>total Post : {{ $total_post }}</h1>
    @foreach ($post as $post)
      <div class="block max-w-2xl p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100">
        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 ">Title : {{ $post->title }}
        </h5>
        <p class="text-base font-normal text-gray-700 duration-300 hover:underline hover:font-semibold"><a
            href="/authors/{{ $post->author->username }}">Author:
            {{ $post->author->name }}</a></p>
        <p class="my-4 text-sm font-medium text-gray-700">Post Category: {{ $post->category->category_name }}</p>
        <p class="text-xs font-normal text-gray-6">Body {{ $post->body }}</p>
        <p class="mt-2 text-sm font-normal text-gray-6600">Create At {{ $post->created_at->format('l, j-m-y / h:i:s') }}
        </p>
        <p class="mt-2 text-sm font-normal text-gray-800">Update At {{ $post->updated_at->format('l, j-m-y / h:i:s') }}
        </p>
        <a href="/post/{{ $post->slug }}">detail</a>
      </div>
    @endforeach
  </div>
</body>

</html>
