use moneyiq;
SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;
delete from issuer where issuer_id>0;
ALTER TABLE issuer AUTO_INCREMENT = 1;

insert into issuer (issuer_name,update_time, update_user) values
 ('株式会社リクルートライフスタイル',NOW(),'benfries')
,('ファミマＴカード',NOW(),'benfries')
,('株式会社セブン・カードサービス',NOW(),'benfries')
,('楽天カード株式会社',NOW(),'benfries')
,('三井住友カード株式会社',NOW(),'benfries')
,('ＪＸ日鉱日石エネルギー株式会社',NOW(),'benfries')
,('TSUTAYA',NOW(),'benfries')
,('NIHONDO',NOW(),'benfries')
,('SMBC',NOW(),'benfries')
,('Credit Saison',NOW(),'benfries')
,('三井住友トラスト',NOW(),'benfries')
,('ジャックス',NOW(),'benfries')
,('株式会社ＪＡＬカード',NOW(),'benfries');

SET FOREIGN_KEY_CHECKS = 1;
