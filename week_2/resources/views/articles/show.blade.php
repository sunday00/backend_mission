<x-app-layout>
    <section class="main p-8">
        <h2 class="text-2xl my-4"> {{ $article->title }} </h2>
        <article>
            {{ $article->body }}
        </article>
        <p class="mt-4"> {{ $article->created_at }} </p>
    </section>

    <section class="tags my-4 text-right p-8">
        @foreach ($article->tags as $tag)
            <x-articles.tag>{{ $tag->name }}</x-articles.tag>
        @endforeach
    </section>

    <section class="control mt-4 flex gap-2 p-8">
        <x-forms.anchor href="{{ route('article.index') }}" name="back to list" color="blue" />
        <x-forms.anchor href="{{ route('article.edit', $article->id) }}" name="edit" color="blue" />

        <form action="{{ route('article.destroy', $article->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <x-forms.button type="submit" name="delete" color="red" />
        </form>
    </section>
</x-app-layout>
