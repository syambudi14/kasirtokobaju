<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction; // Assuming Transaction model exists or using DB facade.
// Since we used DB facade in TransactionController, I should check if Transaction model exists.
// Checking file list previously, I didn't see Transaction model explicitly used but let's check.
// Actually, I'll use DB facade to be consistent with TransactionController or create a Model if it makes sense. 
// Given the previous code used DB facade for insertions, extracting data via DB facade is fine too, 
// but using Models is more Laravel-way. Let's start with DB facade for complex aggregates if needed, 
// or Models if they exist.
// Wait, I haven't seen a Transaction model file. I should probably create one or use DB.
// To be safe and quick without creating extra files unless needed, I'll use DB facade but 
// a Model is better for relationships (User).
// Let's assume I need to join with users.

// Actually, looking at the plan: "Fetch paginated transactions with User relationship."
// This implies I should probably have a Transaction model.
// Let's check if Transaction model exists.
// I will assume it doesn't and use DB facade with joins for now to be safe, OR I will create it.
// Actually, earlier migrations created `transactions` table.
// I'll stick to DB facade for now to match the style I saw in TransactionController, 
// but for "User" name I need a join.

?>
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('transactions')
            ->join('users', 'transactions.user_id', '=', 'users.id')
            ->select('transactions.*', 'users.name as cashier_name');

        // Role-based Access Control
        $user = auth()->user();
        if ($user->role !== 'admin') {
            $query->where('transactions.user_id', $user->id);
        }

        // Filter Date
        if ($request->start_date && $request->end_date) {
            $query->whereBetween('transactions.created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }

        // Clone query for aggregates to avoid resetting
        $aggregateQuery = clone $query;

        // Aggregates
        $totalOmset = $aggregateQuery->sum('transactions.total_amount');
        $totalTransactions = $aggregateQuery->count();

        // Item sold needs a join with details
        // We can do a separate query for this for performance or simplicity
        $transactionIds = $aggregateQuery->pluck('transactions.id');
        $itemsSold = DB::table('transaction_details')
            ->whereIn('transaction_id', $transactionIds)
            ->sum('quantity');

        // Fetch Data (Paginated)
        $transactions = $query->orderBy('transactions.created_at', 'desc')->paginate(10);

        // Append query parameters to pagination links
        $transactions->appends($request->all());

        return view('backend.laporan.index', compact(
            'transactions',
            'totalOmset',
            'totalTransactions',
            'itemsSold'
        ));
    }
}
