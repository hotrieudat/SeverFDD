begin;

--Data Reset
TRUNCATE user_mst CASCADE;

INSERT INTO user_mst
VALUES ('000001', 'admin', '8d9548f95b0a4e77a1bb8cb047da8045c76a75047613edf48f52487d08ade5eb', 'システム管理者', 'システムカンリシャ',
        't-kimura@plott.jp', NULL, '2018-09-05 10:24:03', '2018-09-05 10:22:19', 1, 1, 1, 0,
        '                                                                ', NULL, 1, 'システム管理企業', 1, 0, 0, '000001',
        '      ', '2018-09-05 10:22:19', '2018-09-05 10:24:02');
INSERT INTO user_mst
VALUES ('000002', 'sampleuser01', 'b1d51bad3c06219936a4d5284209ba55b2b3ca22e7ed070fb13cdf8a0229c964', 'sampleuser01',
        'サンプルイチ', 'sampleuser01@plott.jp', NULL, NULL, '1970-01-01 00:00:00', 1, 0, 1, 0, NULL, NULL, 1, 'ホスト１企業', 1, 0,
        0, '000001', '000001', '2018-09-05 10:26:37', NULL);
INSERT INTO user_mst
VALUES ('000003', 'sampleuser02', 'c586b243d3f61e093430dd8c8d9bbfba71242b9a7eccec23f841160de2e92e6e', 'sampleuser02',
        'サンプルニ', 'sampleuser02@plott.co.jp', NULL, NULL, '1970-01-01 00:00:00', 0, 0, 1, 0, NULL, NULL, 0, 'ゲスト1企業', 1,
        0, 0, '000001', '000001', '2018-09-05 10:27:46', '2018-09-05 11:00:14');

UPDATE user_license_rec
SET mac_addr    = '11:11:11:11:11:11',
    host_name   = 'TEST',
    os_version  = 'Win10',
    os_user     = 'TEST-PC',
    update_date = now()
WHERE user_id = '000001';
INSERT INTO user_license_rec
VALUES ('000001', '0002', 'AA:AA:AA:AA:AA:AA', 'MSDN', 'Win7', 'MSDN-PC', '000001', '000001', now(), now());
INSERT INTO user_license_rec
VALUES ('000001', '0003', 'BB:BB:BB:AB:BB:BB', 'Plott', 'Win8', 'Plott-PC', '000001', '000001', now(), now());

UPDATE option_mst SET max_license_count = 4;

commit;
