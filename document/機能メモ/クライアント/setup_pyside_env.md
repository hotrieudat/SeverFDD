# Python + PySide開発、ビルド環境構築方法

## 初めに
FileKeyプロジェクトのための、クライアント側GUIアプリケーションの開発、ビルド環境を構築する方法を記す
開発補助を除く、必要なソフトウェア、バージョンは以下のとおりである
* Python 3.4
* PySide 1.2.4
* PyInstaller 3.2.1
* request 2.13.0
* pycrypto 2.6.1

現在(2017/4/14)PySideのバージョンは1系と2系があるが、2系は情報が少なく、バイナリの提供もなく(＝ビルドが必要)、利用しづらいので今回はPySide1系を利用する
そして、PySide1系はPython3.5以降では利用できないので、Python3.4を利用することとする  
しかしPython3.4は最新版ではなく、これをシステム唯一のPythonとするようなインストールの仕方は避けたい。そのため、各OSでPythonのバージョンを切り替えられるような
構成とする

## Windows
事前のPythonやQtのインストールは不要である

### Anaconda(Miniconda)のインストール
Anaconda(Miniconda)は、データサイエンティスト向けPythonディストリビューションである  
Pythonのバージョンを指定し、導入ライブラリも分離した仮想環境を作る機能を持つ  
Pythonにおいては、プロジェクトごとに仮想環境を作成するのが一般的である  
本来はPython仮想環境の作成はPyenv + Virtuanenvで行うのが一般的なのだが、PyenvはWindowsでは利用できないのでこの方法を取ることとする  
AnacondaとMinicondaの違いは、科学処理系ライブラリ、補助アプリケーションがバンドルされているかどうかの違いである  
好みでよいが、特に理由がなければMinicondaをインストールすれば良い

インストール手順は、[Anaconda公式サイト](https://www.continuum.io/downloads)もしくは[Miniconda公式サイト](https://conda.io/miniconda.html)よりインストーラーをダウンロードし、実行するのみである

### 仮想環境構築
インストールが完了したので、仮想環境の作成を行う  
ここでは仮想環境の名前を「filekey」とする  
なお、前項でインストールしたパッケージがAnacondaであるか、Minicondaであるかは操作に関係しない

コマンドプロンプトを開き、以下のように入力する
```
conda create -n filekey python=3.4
```
途中[y/n]入力が求められる場面があるので、yを入力する  
特に問題なく環境の構築が完了するはずである

### 仮想環境への必要なパッケージのインストール
仮想環境は作成しただけでは利用することができない  
コマンドプロンプトにて仮想環境を利用するには以下のコマンドを入力する
```
activate filekey
```
これはコマンドプロンプトを起動するたび毎回入力する必要がある  
仮想環境から抜けるには以下のように入力する
```
deactivate
```

それでは、パッケージをインストールする
Anaconda/Miniconda側のパッケージ管理システムには必要なパッケージが準備されていないので、
Python側のパッケージマネージャーであるpipを利用する

以下のコマンドでPyInstallerをインストールする
```
pip install pyinstaller
```
次に、PySideをインストールする
同様に
```
pip install PySide
```
としたいところなのだが、Windowsにおいて、環境によってはPySideはこの方法ではインストールできない場合がある  
そこで[ここ](https://download.qt.io/official_releases/pyside/PySide-1.2.4-cp34-none-win_amd64.whl)よりビルド済みパッケージをダウンロード、以下のコマンドを実行することでインストールすることができる

```
pip install [ダウンロードした.whlファイルへのパス]
```
余談だが、Shiftを押しながらファイルアイコンを右クリックすることでファイルのフルパスをクリップボードにコピーできる  
(参考サイト:[PySideをpipでインストールしようとするとエラーを吐く場合の回避策 - Qiita](http://qiita.com/nebula121/items/10d97b70aac122098c10))

requests及びpycryptoはcondaコマンドにてインストール可能である
```
conda install pycrypto
conda install requests
```


### ビルド
すでにPySideアプリケーションを実行することができるはずである
exe化するためには以下のコマンドを実行する  
hoge.pyが実行スクリプトであるとする
```
pyinstaller -wy --hidden-import multiprocessing hoge.py
```
(※ multiprocessingはrequestsが必要としている)  
すると、Pythonスクリプトのあるディレクトリにbuild, distディレクトリができているはずである  
必要なのはdistディレクトリである
この中のhoge.exeが実行可能バイナリである  
なお、このコマンドはbuild.shとしてスクリプト化されている

