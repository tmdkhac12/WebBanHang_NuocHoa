<?php
require __DIR__ . "/../model/HoaDonModel.php";

class HoaDonController
{
    private $hoaDonModel;

    function __construct()
    {
        $this->hoaDonModel = new HoaDonModel();
    }

    public function getAllHoaDon($maKhachHang)
    {
        $hoadons = $this->hoaDonModel->getAllHoaDonOf($maKhachHang);

        if (!isset($hoadons)) {
            return null;
        }

        $hoadons_grouped = $this->groupHoaDonByMa($hoadons);

        return $hoadons_grouped;
    }

    // Private Functions
    private function groupHoaDonByMa($hoadons) {
        $hoadons_grouped = [];
        $maTruocDo = null;
        $groupIndex = -1;

        foreach ($hoadons as $item) {
            if ($item['ma_hoa_don'] !== $maTruocDo) {
                $groupIndex++; // Tăng index nhóm khi gặp mã hóa đơn mới
                $maTruocDo = $item['ma_hoa_don'];
            }

            $hoadons_grouped[$groupIndex][] = $item;
        }

        return $hoadons_grouped;
    }
}
