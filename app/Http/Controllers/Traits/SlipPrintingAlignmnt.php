<?php
namespace App\Http\Controllers\Traits;

trait SlipPrintingAlignmnt
{
    public function setItemNoAligned($str= "", $availableCount=0)
    {
        $availableSpace = 3;
        $str = $this->setCommonAlignment($str, $availableSpace, 'right');
        return $str;
    }

    public function setItemAligned($str= "", $availableCount=0)
    {
        $availableSpace = 16;
        $str = $this->setNewLineAt($str, $availableSpace);
        $strCount = strlen($str);

        // For not new line item name adding left alignment
        if($strCount < $availableSpace){
            $str = $this->setCommonAlignment($str, $availableSpace, 'left');
        }

        return $str;
    }

    public function setQtyAligned($str= "", $availableCount=0)
    {
        $availableSpace = 5;
        $str = $this->setCommonAlignment($str, $availableSpace, 'right');
        return $str;
    }

    public function setPriceAligned($str= "", $availableCount=0)
    {
        $availableSpace = 9;
        $str = $this->setCommonAlignment($str, $availableSpace, 'right');
        return $str;
    }

    public function setAmountAligned($str= "", $availableCount=0)
    {
        $availableSpace = 9;
        $str = $this->setCommonAlignment($str, $availableSpace, 'right');
        return $str;
    }


    private function setCommonAlignment($str= "", $availableCount=0, $align="left")
    {

        $strCount = strlen($str);

        if($strCount > 0){
            $numberOfSpaceToAdd = $availableCount - $strCount;
            $addedSpace = "";

            for($i = 0; $i < $numberOfSpaceToAdd; $i++){
                $addedSpace .=" ";
            }

            if($align == 'left'){
                $alignedString = $str.$addedSpace;
            }
            elseif($align == 'right'){
                $alignedString = $addedSpace.$str;
            }



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

    /**
     * To append new line character for printing at specific string length
     * @param String $str
     * @param int $pos
     * @return String $str
     * @since 2021-08-06
     * @author Htoo Maung Thait
    */
    private function setNewLineAt($str, $pos)
    {

        $stringArray = str_split($str);
        $count = count($stringArray);
        $dividing = floor($count / $pos);

        for($i = 1; $i <= $dividing; $i++)
        {
            $arrPosition = ($i * $pos) - 1;
            $stringArray[$arrPosition] = "- \n ";
        }

        $str = implode($stringArray);
        return $str;

    }
}
