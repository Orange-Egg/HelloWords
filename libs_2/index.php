<?php
// autoloadなし
require_once('libs/db/db.php');
require_once('libs/db/db_parent.php');
// autoloadあり
use libs\db\db;
use libs\utils\DateUtils;
use libs\consts\AppConstants;
//
// 1.windows版のcomposerのインストール
// cmd(コマンドプロンプト)からcomposer.jsonファイルがあるフォルダ上でcomposer installを実行
//

// クラスとは？
// *オブジェクト指向
// *デザインパターン(たくさんあります)
//  + abstract パターン

// インターフェース

// トレイト(多重継承)
$db = new db();
$db->connect();
echo (DateUtils::getNow());
$db->disconnect();
?>
<html>
<div><?=AppConstants::MESAGE_SUCCESS?></div>
</html>