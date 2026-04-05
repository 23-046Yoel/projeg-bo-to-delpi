<?php

namespace App\Services;

use Revolution\Google\Sheets\Facades\Sheets;

class GoogleSheetService
{
    public function syncSupplier(\App\Models\Supplier $supplier)
    {
        $this->append('Suppliers', [
            $supplier->id,
            $supplier->name,
            $supplier->village,
            $supplier->phone,
            $supplier->items,
            $supplier->price,
            $supplier->created_at
        ]);
    }

    public function syncBeneficiary(\App\Models\Beneficiary $beneficiary)
    {
        $this->append('Beneficiaries', [
            $beneficiary->id,
            $beneficiary->name,
            $beneficiary->parent_name,
            $beneficiary->marga,
            $beneficiary->origin,
            $beneficiary->address,
            $beneficiary->school,
            $beneficiary->dob,
            $beneficiary->weight,
            $beneficiary->height,
            $beneficiary->allergies,
            $beneficiary->notes,
            $beneficiary->created_at
        ]);
    }

    public function syncPayment(\App\Models\Payment $payment)
    {
        $this->append('Payments', [
            $payment->id,
            $payment->sppg_id,
            $payment->amount,
            $payment->status,
            $payment->notes,
            $payment->created_at
        ]);
    }

    public function syncMaterialLog(\App\Models\MaterialLog $log)
    {
        $this->append('MaterialLogs', [
            $log->id,
            $log->sppg_id,
            $log->material->name ?? 'Unknown',
            $log->type,
            $log->quantity,
            $log->date,
            $log->created_at
        ]);
    }

    public function syncMbgDistribution(\App\Models\MbgDistribution $dist)
    {
        $this->append('MBG_Distributions', [
            $dist->id,
            $dist->sppg_id,
            $dist->beneficiary->name ?? 'Bulk',
            $dist->quantity,
            $dist->distributed_at,
            $dist->created_at
        ]);
    }

    public function syncMenu(\App\Models\Menu $menu)
    {
        $this->append('Menus', [
            $menu->id,
            $menu->date,
            $menu->content,
            $menu->sppg_id,
            $menu->created_at
        ]);
    }

    private function append(string $sheetName, array $data)
    {
        try {
            $spreadsheetId = config('services.google.spreadsheet_id');
            if (!$spreadsheetId) return;
            
            Sheets::spreadsheet($spreadsheetId)->sheet($sheetName)->append([$data]);
        } catch (\Exception $e) {
            \Log::error("Google Sheet Sync Failed: " . $e->getMessage());
        }
    }
}
