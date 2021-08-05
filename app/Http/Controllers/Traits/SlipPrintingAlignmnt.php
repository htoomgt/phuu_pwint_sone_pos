<?php
namespace App\Http\Controllers\Traits;

trait SlipPrintingAlignmnt
{
    public function setItemNoAligned($str= "", $availableCount=0)
    {
        $availableSpace = 3;
        $str = $this->setCommonRightAlignment($str, $availableSpace);
        return $str;
    }

    public function setItemAligned($str= "", $availableCount=0)
    {
        $availableSpace = 16;
        $str = $this->setCommonRightAlignment($str, $availableSpace);
        return $str;
    }

    public function setQtyAligned($str= "", $availableCount=0)
    {
        $availableSpace = 5;
        $str = $this->setCommonRightAlignment($str, $availableSpace);
        return $str;
    }

    public function setPriceAligned($str= "", $availableCount=0)
    {
        $availableSpace = 9;
        $str = $this->setCommonRightAlignment($str, $availableSpace);
        return $str;
    }

    public function setAmountAligned($str= "", $availableCount=0)
    {
        $availableSpace = 9;
        $str = $this->setCommonRightAlignment($str, $availableSpace);
        return $str;
    }


    private function setCommonRightAlignment($str= "", $availableCount=0)
    {

        $strCount = strlen($str);

        if($strCount > 0){
            $numberOfSpaceToAdd = $availableCount - $strCount;
            $addedSpace = "";

            for($i = 0; $i < $numberOfSpaceToAdd; $i++){
                $addedSpace .=" ";
            }

            $alignedString = $addedSpace.$str;

            return $alignedString;

        }
        else{
            return $str;
        }
    }

    private function setSlipLineBreak($printer)
    {
        for($i = 1; $i <= 48; $i++){
            $printer->text("-");
        }
        $printer->text("\n");
    }
}
