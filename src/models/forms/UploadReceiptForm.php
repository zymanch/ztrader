<?php
namespace backend\models\forms;

use backend\models\Receipt;
use yii\base\InvalidArgumentException;
use yii\base\Model;
use yii\web\UploadedFile;
use Zxing\QrReader;

class UploadReceiptForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $receipt;
    public $user_id;

    public function rules()
    {
        return [
            [['receipt'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
            [['user_id'], 'integer'],
        ];
    }

    public function getQrCode()
    {
        if (!$this->validate()) {
            throw new InvalidArgumentException('Ошибка загрузки файла'.json_encode($this->getErrors()));
        }
        $extension = strtolower(pathinfo($this->receipt->name,PATHINFO_EXTENSION ));
        switch ($extension) {
            case 'jpg':case 'jpeg':
                $gd = imagecreatefromjpeg($this->receipt->tempName);
                break;
            case 'png':
                $gd = imagecreatefrompng($this->receipt->tempName);
                break;
            default:
                throw new InvalidArgumentException('Неизвестный формат файла чека');
        }

        $parser = new QrReader($gd, QrReader::SOURCE_TYPE_RESOURCE, false);
        $qrCode = $parser->text();
        if (!$qrCode) {
            throw new InvalidArgumentException('QR-код не найден');
        }
        return $qrCode;
    }

    public function createReceipt()
    {
        $qrCode = $this->getQrCode();
        $params = $this->_getParams($qrCode);

        $receipt = new Receipt();
        $receipt->created = date('Y-m-d H:i:s');
        $receipt->user_id = $this->user_id;
        $receipt->qr_code = $qrCode;
        if (isset($params['t']) && $t = strtotime($params['t'])) {
            $receipt->date = date('Y-m-d H:i:s', $t);
        }
        if (isset($params['s'])) {
            $receipt->amount = $params['s'];
        }
        $receipt->save(false);
    }

    private function _getParams($qrCode)
    {
        $params = [];
        parse_str($qrCode, $params);
        if (!$params) {
            return [];
        }
        return $params;
    }
}