<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class OpenAIController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function productInfo()
    {
        return view('products.generateInfo');
    }

    public function generateProductAndImage($categoryId, $keys)
    {
        $category = Category::findOrFail($categoryId);
        $apiKeyGemini = env('GEMINI_KEY');
        $apiKeyHuggingFace = env('HUGGIN_FACE');

        $model = "gemini-1.5-pro"; 
        $apiUrl = "https://generativelanguage.googleapis.com/v1/models/$model:generateContent?key=$apiKeyGemini";

        $keywords = explode(',', $keys);
        $prompt = "Generate a product in the '{$category->name}' category using keywords: " . implode(', ', $keywords) . ".\n
                   Provide a JSON response with fields: name, description, price (random but reasonable).
                   Strictly return only JSON without Markdown formatting or extra text.";

        $response = Http::withoutVerifying()->post($apiUrl, [
                    'contents' => [
                        ['role' => 'user', 'parts' => [['text' => $prompt]]]
                    ],
                ]);
    
        $data = $response->json();

        $rawResponse = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;
        $cleanResponse = preg_replace('/```/', '', $rawResponse); // Remove the triple backticks
        $cleanResponse = preg_replace('/json\n|\n/', '', $cleanResponse); // Remove the 'json' and newline characters
        
        
        $jsonResponse = json_decode($cleanResponse, true);
        

        
        $imagePrompt = "A high-quality realistic image of a product named '{$jsonResponse['name']}' in the category '{$category->name}'.";
        
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKeyHuggingFace,
            'Content-Type' => 'application/json',
        ])->withOptions([
            'verify' => false,  
        ])->post('https://api-inference.huggingface.co/models/stabilityai/stable-diffusion-2', [
            'inputs' => $imagePrompt,
            'wait_for_model' => true,
        ]);
        $imageData = $response->body();
        $filename = 'products/' . uniqid() . '.png';
        Storage::disk('public')->put($filename, $imageData);
        session(['filename' => $filename]); 
        return view('products.generateInfo', compact('jsonResponse','category','filename'));


    }

    // app/Http/Controllers/OpenAIController.php
    public function generateProductBack()
    {
        // Delete the image file if it exists
        $filename = session('filename'); // Assuming the filename was stored in the session
        if ($filename && Storage::disk('public')->exists($filename)) {
            Storage::disk('public')->delete($filename);
        }
        return redirect()->route('openai.formprompt')->with('success', 'Suprimme Image generate success');
    }

    // Store the product in the database
    public function storeProduct(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'required',
        ]);

        // Save the product in the database
        $product = Product::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'category_id' => $validated['category'],
            'image' => $validated['image'], 
        ]);

        return redirect()->route('products.index')->with('success', 'Product saved successfully!');
    }


    // Show the form to generate a product
    public function showForm()
    {
        $categories = Category::all();
        return view('products.generate', compact('categories'));
    }

    



}
