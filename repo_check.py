#!/usr/bin/env python
# -*- coding: utf-8 -*-

import sys

"""
変更してはいけないファイルが変更されていないかを検知する
機能は今後増やしていく可能性あり

標準入力から、変更されたファイルを改行区切りで受け取る
ファイルはリポジトリのルートディレクトリからの相対パス

"""

FILES_NOBODY_CAN_MODIFY = [
    "database/set_up_sql/create.sql",
    "database/set_up_sql/plott_framework_create.sql",
    "database/insert_data/insert_data.sql",
    "database/insert_data/word_mst.sql",
    "database/view/create.sql"
]

if __name__ == "__main__":

    is_modified = False
    for modified_file in sys.stdin:
        stripped_modified_file = modified_file.strip()
        if stripped_modified_file in FILES_NOBODY_CAN_MODIFY:
            print("Don't modify {}!".format(stripped_modified_file))
            is_modified = True

    sys.exit(1 if is_modified else 0)
