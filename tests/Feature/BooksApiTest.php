<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BooksApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_get_all_books()
    {
        $books = Book::factory(6)->create();

        $this->getJson(route('books.index'))->assertJsonFragment([
            "title" => $books[5]->title
        ]);
    }

    /** @test */
    public function can_get_one_book()
    {
        $book = Book::factory()->create();

        $this->getJson(route('books.show', $book))->assertJsonFragment([
            'title' => $book->title
        ]);
    }

    /** @test */
    public function can_create_book()
    {
        $this->postJson(route('books.store'), [
            'title' => 'A simple book'
        ])->assertJsonFragment([
            'title' => 'A simple book'
        ]);

        $this->assertDatabaseHas('books', [
            'title' => 'A simple book'
        ]);
    }

    /** @test */
    public function cant_create_book_without_validation()
    {
        $this->postJson(route('books.store'), [])
            ->assertJsonValidationErrorFor('title');
    }

    /** @test */
    public function can_update_book()
    {
        $book = Book::factory()->create();

        $this->patchJson(route('books.update', $book), [
            'title' => 'Edited book'
        ])->assertJsonFragment([
            'title' => 'Edited book'
        ]);

        $this->assertDatabaseHas('books', [
            'title' => 'Edited book'
        ]);
    }

    /** @test */
    public function cant_update_book_without_validation()
    {
        $book = Book::factory()->create();

        $this->patchJson(route('books.update', $book), [])
            ->assertJsonValidationErrorFor('title');
    }

    /** @test */
    public function can_delete_book()
    {
        $book = Book::factory()->create();

        $this->deleteJson(route('books.destroy', $book))
            ->assertNoContent();

        $this->assertDatabaseCount('books', 0);
    }
}
