<?php

// 建立 base.php 檔，用來放共用的設定、變數、常數及函式。
class DB{
    // 設定好PDO的連線參數 $pdo=new PDO()
    //private 宣告屬性 (安全性考量)
    // charset=utf8 中文編碼設定 
    private $dsn="mysql:host=localhost;charset=utf8;dbname=db_story";
    // 資料庫設定
    private $root='root';
    private $password='';
    private $table;
    private $pdo;
    
    //設定建構式
    public function __construct($table){
        // 將建立物件時代入的資料表名稱代入類別中的屬性table
        $this->table=$table;
        //建立pdo的連線資訊，並將pdo連線指定給類別內的屬性pdo
        $this->pdo=new PDO($this->dsn,$this->root,$this->password);
    }


    // 建立全域變數或是共用函式

    // all(...$arg不定參數:不確定有多少參數 與jS其餘參數的概念類似) - 取得資料表的全部資料或是特定條件的全部資料
    public function all(...$arg){
        $sql="select * from $this->table ";

        // 每使用一次 fetchAll() 或 fetch() 之前，一定要先 query() 。
        // fetchAll()，一次取出所有陣列。fetch() 一次取單筆資料，取完後指標會指向下一筆資料。
        // https://jsnwork.kiiuo.com/archives/921/php-%E4%BD%BF%E7%94%A8pdo%E9%80%A3%E8%B3%87%E6%96%99%E5%BA%AB%E9%81%87%E5%88%B0%E7%9A%84query%E3%80%81fatch%E3%80%81fetchall%E7%9A%84%E5%95%8F%E9%A1%8C-2/
        return $this->pdo->query($sql)->fetchAll();

    }
}

$db=new DB("user");
echo "<pre>";
print_r($db->all());
echo "</pre>";


$db2=new DB("stories");
echo "<pre>";
print_r($db2->all());
echo "</pre>";
?>