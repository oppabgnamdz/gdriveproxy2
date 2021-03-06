<?php

/**
 * ====================================================================================
 *                           Google Drive Proxy Player (c) CodySeller
 * ----------------------------------------------------------------------------------
 * @copyright This software is exclusively sold at codester.com. If you have downloaded this
 *  from another site or received it from someone else than me, then you are engaged
 *  in an illegal activity. You must delete this software immediately or buy a proper
 *  license from https://www.codester.com/codyseller?ref=codyseller.
 *
 *  Thank you for your cooperation and don't hesitate to contact me if anything :)
 * ====================================================================================
 *
 * @author CodySeller (http://codyseller.com)
 * @link http://codyseller.com
 * @license http://codyseller.com/license
 */



class Upload 
{

    protected $dir = ROOT . '/uploads';
    protected $error = '';
    protected $resp = [];
    protected $files = [];
    protected $allowedExt = [];
    protected $maxSize = UPLOAD_MAX_SIZE;


    public function __construct($dir = '')
    {

        if(!empty($dir))
        {
            $this->dir .= '/' . $dir;
        }
        $this->check();

    }


    public function upload($file)
    {
        if(!empty($file))
        {
            $this->build($file);
        }

        if(!$this->hasError())
        {
            if(!empty($this->files))
            {
                foreach($this->files as $k => $v)
                {
                    foreach($v as $fk => $fv)
                    {
                        if($fv['error'] === UPLOAD_ERR_OK)
                        {
                            if($this->isAllowedExt($fv['ext']))
                            {
                                if($this->isallowedSize($fv['size']))
                                {
                                    @move_uploaded_file($fv['tmp_name'], $this->dir . '/' . $fv['name']);
                                    $this->resp['s'][$fk] = $fv['name'];
                                    continue;
                                }
                                else
                                {
                                    $e = 'T???i l??n th???t b???i ! ->  <b> '.$fv['name'].' </b> L???I: T???i l??n k??ch th?????c t???p t???i ??a l?? ' . Helper::formatSizeUnits($this->maxSize); 
                                }
                            }
                            else
                            {
                                $e = 'T???i l??n th???t b???i ! ->  <b> '.$fv['name'].' </b> L???I: ?????nh d???ng t???p kh??ng h??? tr??? !';
                            }
                        }
                        else
                        {
                            if($fv['error'] === UPLOAD_ERR_NO_FILE) continue;
                            $e = 'T???i l??n th???t b???i ! -> <b> '.$fv['name'].' </b> ERROR : ' .  $this->getErrorMsg($fv['error']);
                        }
                        $this->resp['e'][$fk] = $e;
                    }
                }
            }
            else
            {
                $this->error = 'T???p t???i l??n b??? thi???u !';
            }
        }

        return empty($this->resp['e']) && !$this->hasError() ? true : false;


    }


    public function setExt($exts)
    {
        if(is_array($exts))
        {   
            $this->allowedExt = $exts;
        }
        
    }


    protected function check()
    {
        if(!file_exists($this->dir))
        {
            $ret = @mkdir($this->dir, 0755, true); 
            if($ret !== true)
            {
                $this->error = $this->dir . ' kh??ng t???n t???i !';
            }
        }
        else
        {
            if(!is_writable($this->dir))
            {
                $this->error = $this->dir . ' kh??ng ghi ???????c !';
            }
        }



    }


    public function hasError()
    {
        if(!empty($this->error))
        {
            return true;
        }
        return false;
    }

    public function getError()
    {
        return $this->error;
    }

    public function getResp()
    {
        return $this->resp;
    }



    protected function getErrorMsg($code)
    {
        switch ($code) {
            case UPLOAD_ERR_INI_SIZE:
                $message = "T???p ???????c t???i l??n v?????t qu?? ch??? th??? upload_max_filesize trong php.ini";
                break;
            case UPLOAD_ERR_FORM_SIZE:
                $message = "T???p ???????c t???i l??n v?????t qu?? ch??? th??? MAX_FILE_SIZE ???? ???????c ch??? ?????nh trong bi???u m???u HTML";
                break;
            case UPLOAD_ERR_PARTIAL:
                $message = "T???p ???? t???i l??n ch??? ???????c t???i l??n m???t ph???n";
                break;
            case UPLOAD_ERR_NO_FILE:
                $message = "Kh??ng c?? t???p n??o ???????c t???i l??n";
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                $message = "Thi???u m???t th?? m???c t???m th???i";
                break;
            case UPLOAD_ERR_CANT_WRITE:
                $message = "Ghi t???p v??o ????a kh??ng th??nh c??ng";
                break;
            case UPLOAD_ERR_EXTENSION:
                $message = "T???i t???p l??n ???? ng???ng do ti???n ??ch m??? r???ng";
                break;

            default:
                $message = "L???i t???i l??n kh??ng x??c ?????nh";
                break;
        }
        return $message;
    }


    protected function isAllowedExt($ext)
    {
        if(empty($this->allowedExt) || (!empty($this->allowedExt) && is_array($this->allowedExt) && in_array(strtolower($ext), $this->allowedExt)))
        {
            return true;
        }
        return false;
    }


    protected function isallowedSize($s)
    {   
        if(empty($this->maxSize) || (!empty($this->maxSize) && $s <= $this->maxSize) )
        {
            return true;
        }
        return false;
    }


    protected function build($file)
    {

        if(is_array($file))
        {

            if(isset($file['name']))
            {

                if(is_array($file['name']))
                {

                    foreach($file['name'] as $fk => $fv)
                    {
                        foreach($fv as $k => $v)
                        {
                            $name = $v;
                            $ext = pathinfo($name, PATHINFO_EXTENSION);
                            $this->files[$k][$fk] = [
                                'name' => $name,
                                'type' => $file['type'][$fk][$k],
                                'tmp_name' => $file['tmp_name'][$fk][$k],
                                'error' => $file['error'][$fk][$k],
                                'size' => $file['size'][$fk][$k],
                                'ext' => $ext
                            ];

                        }
                    }

                }
                else
                {
                    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                    $file['ext'] = $ext;
                    $this->files[][] = $file;
                }

            }
            else
            {
                $this->error = 'D??? li???u t???p kh??ng h???p l??? ???????c cung c???p ????? t???i l??n';
            }

        }
        else
        {
            $this->error = '???? cung c???p ?????i s??? kh??ng h???p l??? ????? t???i l??n';
        }

    }






}