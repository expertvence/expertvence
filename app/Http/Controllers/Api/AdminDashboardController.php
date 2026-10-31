<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectTransaction;
use App\Models\ShareMember;
use App\Models\ProfitDistribution;

class AdminDashboardController extends Controller
{
    public function stats()
    {
        $totalIncome = (float) ProjectTransaction::where('type', 'income')->sum('amount');
        $totalExpense = (float) ProjectTransaction::where('type', 'expense')->sum('amount');
        $netProfit = $totalIncome - $totalExpense;
        $totalDistributed = (float) ProfitDistribution::sum('amount');
        $availableBalance = $netProfit - $totalDistributed;

        $projectsCount = Project::count();
        $membersCount = ShareMember::count();

        // Member wise summary ("kake koto deowa holo")
        $members = ShareMember::with('profitDistributions')->get()->map(function ($m) {
            $totalReceived = (float) $m->profitDistributions->sum('amount');
            return [
                'id' => $m->id,
                'name' => $m->name,
                'designation' => $m->designation,
                'image' => $m->image,
                'total_received' => $totalReceived,
            ];
        });

        // Recent 5 transactions
        $recentTransactions = ProjectTransaction::with('project')
            ->orderBy('transaction_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Recent 5 projects
        $recentProjects = Project::orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => [
                'total_income' => $totalIncome,
                'total_expense' => $totalExpense,
                'net_profit' => $netProfit,
                'total_distributed' => $totalDistributed,
                'available_balance' => $availableBalance,
                'projects_count' => $projectsCount,
                'members_count' => $membersCount,
                'members_summary' => $members,
                'recent_transactions' => $recentTransactions,
                'recent_projects' => $recentProjects,
            ],
        ]);
    }
}
