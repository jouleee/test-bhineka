<?php

namespace App\Controllers;

use App\Models\SettingModel;

class Settings extends BaseController
{
    public function index()
    {
        $settingModel = new SettingModel();
        // Since settings table should only have 1 row (id=1), we fetch it or create it if missing
        $setting = $settingModel->find(1);

        if (!$setting) {
            // Seed default row if it was deleted
            $settingModel->insert([
                'id'              => 1,
                'company_name'    => 'PT. Bhinneka Sangkuriang Transport',
                'company_address' => 'Jl. Gedebage Selatan No.121A, Cisaranten Kidul, Kec. Gedebage, Kota Bandung, Jawa Barat 40552',
                'company_phone'   => '022-1234567',
                'company_email'   => 'info@bhinnekasangkuriang.co.id'
            ]);
            $setting = $settingModel->find(1);
        }

        return view('settings/index', ['setting' => $setting]);
    }

    public function update()
    {
        $settingModel = new SettingModel();
        
        $data = [
            'company_name'    => $this->request->getPost('company_name'),
            'company_address' => $this->request->getPost('company_address'),
            'company_phone'   => $this->request->getPost('company_phone'),
            'company_email'   => $this->request->getPost('company_email'),
        ];

        $settingModel->update(1, $data);

        return redirect()->to('/settings')->with('success', 'Profil perusahaan berhasil diperbarui.');
    }
}
