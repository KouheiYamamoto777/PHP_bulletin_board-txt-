<?php

class ValidateForm
{
    /**
     * 入力内容バリデーション
     * @param array $data
     * @return array|bool $result|false
     */
    public static function validate_form($data)
    {
        $err = array();
        $result = false;

        $data['name'] = trim($data['name']);
        if($data['name'] === '') {
            $err[] = 'お名前が入力されていません';
        } else if (mb_strlen($data['name']) > 20) {
            $err[] = 'お名前は20文字以内で入力してください';
        }
        $data['message'] = trim($data['message']);
        if($data['message'] === '') {
            $err[] = 'コメントが入力されていません';
        } else if (mb_strlen($data['message']) > 100) {
            $err[] = 'コメントは100文字以内で入力してください';
        }

        if(count($err) === 0) {
            $_SESSION['err'] = null;
            return $result = $data;
        } else {
            $_SESSION['err'] = $err;
            return $result;
        }
    }
}

class FileWrite
{
    /**
     * ファイルへ書き込む処理
     * @param array $data
     * @return bool
     */
    public static function file_write($data)
    {
        $file_pass = '../comment.txt';

        if(is_array($data)) {
            $comment = $data['name'] . '\\+++\\' . $data['message'] . '\\+++\\' . date("Y/m/d - H:i:s") . "\n";
            file_put_contents($file_pass, $comment, FILE_APPEND);
            return true;
        } else {
            return false;
        }
    }
}

class FileRead
{
    /**
     * ファイルから一行ずつ読み込んでから、名前とコメントを配列に代入する処理
     * @param void
     * @return array|bool $result|false
     */
    public static function file_read()
    {
        $data = array();
        $data_array = array();
        
        $line_data = explode("\n", file_get_contents('../comment.txt'));
        foreach($line_data as $key => $value) {
            $data = explode("\\+++\\", $value);
            if(!empty($data[$key])) {
                $data_array[] = array(
                    'name' => $data[0],
                    'message' => $data[1],
                    'date' => $data[2]
                );
            }
        }
        $_SESSION['suc'] = '書き込みが完了しました';
        return $data_array;
    }
}