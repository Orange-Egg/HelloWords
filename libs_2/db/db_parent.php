<?php
// namespace作成
namespace libs\db;
// 親クラス
class db_parent
{
    /**
     * コンストラクタ
     * @param void
     * @return void
     */

    // メソッド
    public function __construct()
    {
        // null判定(変数が値を持たないように初期化する)
        $this->handle = null;
    }

    // 変数 database handle, これを使ってDB接続/切断を行う　newでインスタンス生成が必要
    protected $handle;
    // クラス変数（インスタンスを用意しなくてもアクセス可能）今回は使わない
    static $handle2;
}
