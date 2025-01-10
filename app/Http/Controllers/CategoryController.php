namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Show the specific category
    public function show(Category $category)
    {
        return view('category.show', compact('category'));
    }

    // Show the form for editing a specific category
    public function edit(Category $category)
    {
        return view('category.edit', compact('category'));
    }

    // Delete a specific category
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }
}
