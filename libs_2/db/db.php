<?php
// namespace
namespace libs\db;
// 親クラスを継承（finalを使い、これ以上継承させないようにする）
final class db extends db_parent
{
    /**
     * コンストラクタ
     * @param void
     * @return void
     */
    public function __construct()
    {
        $this->handle = null;
    }
    /**
     * DB接続のメソッド
     * @param void
     * @return bool true:正常 false:それ以外
     */
    public function connect(): bool
    {
        return true;
    }
    public static function disconnect(): bool
    {
        self::$handle2;
        return true;
    }
    /**
     * SELECT
     * @param string $sql SQL
     * @param string $hoge
     * @return array
     */
    public function select(string $sql, string $hoge = null): array
    {
        $sql = $sql;
        return [];
    }
    public function free(): void
    {
    }
}
