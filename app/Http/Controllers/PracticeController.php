<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PracticeController extends Controller
{
    public function index(Request $request) {
        $items = DB::table('people')->get();
        return view('practice.index', ['items'=>$items]);
    }

    public function show(Request $request) {
        $name = $request->name;
        $items = DB::table('people')
            ->where('name', 'like', '%' . $name . '%')
            ->orWhere('mail', 'like', '%' . $name . '%')
            ->get();
        return view('practice.show', ['items'=>$items]);
    }
    
    public function post(Request $request) {
        $items = DB::select('select * from people');
        return view('practice.index', ['items'=>$items]);
    }

    public function add(Request $request) {
        return view('practice.add');
    }

    public function create(Request $request) {
        $param = [
            'name' => $request->name,
            'mail' => $request->mail,
            'age' => $request->age,
        ];
        DB::insert('insert into people (name, mail, age) values(:name, :mail, :age)', $param);
        return redirect('/practice');
    }

    public function edit(Request $request) {
        $param = [
            'id' => $request->id,
        ];
        $item = DB::select('select * from people where id = :id', $param);
        return view('practice.edit', ['form' => $item[0]]);
    }

    public function update(Request $request) {
        $param = [
            'id' => $request->id,
            'name' => $request->name,
            'mail' => $request->mail,
            'age' => $request->age,
        ];
        DB::update('update people set name=:name, mail=:mail, age=:age 
            where id =:id', $param);
        return redirect('/practice');
    }

    public function del(Request $request) {
        $param = [
            'id' => $request->id,
        ];
        $item = DB::select('select * from people where id = :id', $param);
        return view('practice.del', ['form'=>$item[0]]);
    }

    public function remove(Request $request) {
        $param = [
            'id' => $request->id,
        ];
        DB::delete('delete from people where id = :id', $param);
        return redirect('/practice');
    }
}
