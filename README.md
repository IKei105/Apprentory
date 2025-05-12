## Apprentory
『Apprentory』は、アプレンティス生向けに作成した教材、オリジナルプロダクト共有サイトです。<br>
アプレンティス生が学習で使用した教材や、制作したプロダクトを共有することで、同期・他期との交流やスムーズな学習進行をサポートします。 <br>

### リンク: https://apprentory.click/

## トップページ
![画像貼る](https://private-user-images.githubusercontent.com/180067613/442590559-2aa01bb6-5280-41ba-9165-7ea07c1dae91.png?jwt=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJnaXRodWIuY29tIiwiYXVkIjoicmF3LmdpdGh1YnVzZXJjb250ZW50LmNvbSIsImtleSI6ImtleTUiLCJleHAiOjE3NDcwNjgwMDgsIm5iZiI6MTc0NzA2NzcwOCwicGF0aCI6Ii8xODAwNjc2MTMvNDQyNTkwNTU5LTJhYTAxYmI2LTUyODAtNDFiYS05MTY1LTdlYTA3YzFkYWU5MS5wbmc_WC1BbXotQWxnb3JpdGhtPUFXUzQtSE1BQy1TSEEyNTYmWC1BbXotQ3JlZGVudGlhbD1BS0lBVkNPRFlMU0E1M1BRSzRaQSUyRjIwMjUwNTEyJTJGdXMtZWFzdC0xJTJGczMlMkZhd3M0X3JlcXVlc3QmWC1BbXotRGF0ZT0yMDI1MDUxMlQxNjM1MDhaJlgtQW16LUV4cGlyZXM9MzAwJlgtQW16LVNpZ25hdHVyZT05MDllNTA3MTNkM2E3ZDQyNjE3YzkyZDRjZmRiZDljZTNkY2Y2N2YyZGU5MjEwN2Y1MWEzNzdlNWZiMWUzODBiJlgtQW16LVNpZ25lZEhlYWRlcnM9aG9zdCJ9.WOrN9v4T9MYn6Fvvsk5LYcUozxToCwANm0dDdmyxBeA)


## インフラ構成図
![インフラ](./docs/apprentory_diagram.png)

## ER図
![ER図](https://private-user-images.githubusercontent.com/180067613/442844785-bc2391c4-c528-487c-ae58-2750a3a31ffe.png?jwt=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJnaXRodWIuY29tIiwiYXVkIjoicmF3LmdpdGh1YnVzZXJjb250ZW50LmNvbSIsImtleSI6ImtleTUiLCJleHAiOjE3NDcwNjgxODgsIm5iZiI6MTc0NzA2Nzg4OCwicGF0aCI6Ii8xODAwNjc2MTMvNDQyODQ0Nzg1LWJjMjM5MWM0LWM1MjgtNDg3Yy1hZTU4LTI3NTBhM2EzMWZmZS5wbmc_WC1BbXotQWxnb3JpdGhtPUFXUzQtSE1BQy1TSEEyNTYmWC1BbXotQ3JlZGVudGlhbD1BS0lBVkNPRFlMU0E1M1BRSzRaQSUyRjIwMjUwNTEyJTJGdXMtZWFzdC0xJTJGczMlMkZhd3M0X3JlcXVlc3QmWC1BbXotRGF0ZT0yMDI1MDUxMlQxNjM4MDhaJlgtQW16LUV4cGlyZXM9MzAwJlgtQW16LVNpZ25hdHVyZT01NDg1MDY5Yzg5NTA5ZjNmYWZmN2RmNzdhYThlNTI1NGZhZTFlMDhhYzVlZTk3MjFjMjNhYzZjODYyZTVmYTBiJlgtQW16LVNpZ25lZEhlYWRlcnM9aG9zdCJ9.qes4KyZ4tMTleWwBr3a7Hd42f53jyNAn1G4CsFs91fo)

## 使用技術スタック
- PHP (バージョン追記)
- Laravel (バージョン追記)
- MySQL (バージョン追記)
- AWS (EC2 ELB Route53）
- Docker
- JavaScript
- HTML/CSS

## 機能・画面
### ログイン機能
- Discord IDによる認証後、任意のユーザIDとパスワードでログイン可能です。 <br>
ホーム画面に遷移後に各機能を使用できます。


### 一覧
- アプレンティス生が共有した教材やオリジナルプロダクトを閲覧することが出来ます。

カテゴリや使用言語毎の絞込みも可能です。

<table>
  <tr>
    <td align="center">
      <strong>教材一覧</strong><br>
      <img src="./docs/material_screen.png" width="300"/>
    </td>
    <td align="center">
      <strong>オリプロ一覧</strong><br>
      <img src="./docs/product_screen.png" width="300"/>
    </td>
  </tr>
</table>


### 教材・オリジナルプロダクト共有
- 自分が使用した教材、作成したオリジナルプロダクトを共有出来ます。<br>
- 教材は5段階での評価に対応しており、媒体(書籍なのか動画コンテンツなのか、等)の選択が可能です。<br>
- オリジナルプロダクトには複数枚の画像を添付でき、テスター募集やレビュー募集など、投稿の目的に応じた種別を選択できます。

投稿動画貼る
(教材とオリプロ)

### 詳細の閲覧
- 投稿された記事の詳細を閲覧出来ます。
- 教材にはいいね機能、オリジナルプロダクトにはコメント欄を実装しています。

#### 教材詳細画面
![教材投稿](https://private-user-images.githubusercontent.com/180067613/442595872-c171cb38-9d9e-470f-9692-1838e9316759.png?jwt=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJnaXRodWIuY29tIiwiYXVkIjoicmF3LmdpdGh1YnVzZXJjb250ZW50LmNvbSIsImtleSI6ImtleTUiLCJleHAiOjE3NDcwNjg4NzcsIm5iZiI6MTc0NzA2ODU3NywicGF0aCI6Ii8xODAwNjc2MTMvNDQyNTk1ODcyLWMxNzFjYjM4LTlkOWUtNDcwZi05NjkyLTE4MzhlOTMxNjc1OS5wbmc_WC1BbXotQWxnb3JpdGhtPUFXUzQtSE1BQy1TSEEyNTYmWC1BbXotQ3JlZGVudGlhbD1BS0lBVkNPRFlMU0E1M1BRSzRaQSUyRjIwMjUwNTEyJTJGdXMtZWFzdC0xJTJGczMlMkZhd3M0X3JlcXVlc3QmWC1BbXotRGF0ZT0yMDI1MDUxMlQxNjQ5MzdaJlgtQW16LUV4cGlyZXM9MzAwJlgtQW16LVNpZ25hdHVyZT02OTE3YjViYjgyNTIxZGNiNWFiOGVkYTliNzczNmQ5NjYzMTFlNDkxNWRkNGVkZDYxZmQxMGRjOTVjNzAzY2VmJlgtQW16LVNpZ25lZEhlYWRlcnM9aG9zdCJ9.KX3232PjYRb71qKOx_kBwMwR0AaZ0Whi6_JyXTTip88)

#### オリプロ詳細画面
![オリプロ投稿](https://private-user-images.githubusercontent.com/180067613/442595940-66cefbfa-bb66-4eea-acf8-cbfea5a4c565.png?jwt=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJnaXRodWIuY29tIiwiYXVkIjoicmF3LmdpdGh1YnVzZXJjb250ZW50LmNvbSIsImtleSI6ImtleTUiLCJleHAiOjE3NDcwNjg4ODgsIm5iZiI6MTc0NzA2ODU4OCwicGF0aCI6Ii8xODAwNjc2MTMvNDQyNTk1OTQwLTY2Y2VmYmZhLWJiNjYtNGVlYS1hY2Y4LWNiZmVhNWE0YzU2NS5wbmc_WC1BbXotQWxnb3JpdGhtPUFXUzQtSE1BQy1TSEEyNTYmWC1BbXotQ3JlZGVudGlhbD1BS0lBVkNPRFlMU0E1M1BRSzRaQSUyRjIwMjUwNTEyJTJGdXMtZWFzdC0xJTJGczMlMkZhd3M0X3JlcXVlc3QmWC1BbXotRGF0ZT0yMDI1MDUxMlQxNjQ5NDhaJlgtQW16LUV4cGlyZXM9MzAwJlgtQW16LVNpZ25hdHVyZT0xY2Y2YzI5MzQzZWY1ZWY4OWI4NjA5Y2E3ZDVmNzJiZjYyYmI1MzY1NjMxN2YxM2ZjMWQyNWE3ZDczOGM5OTBkJlgtQW16LVNpZ25lZEhlYWRlcnM9aG9zdCJ9.Tk5FjBsuDTNYZhPx6ppvpCV31wLHvogPvc4QJjCenFc)


### 検索機能
- サイト内検索に対応しており、言語、もしくはテキストから一致するものを絞り込めます。

### フォロー機能
- 気になったユーザをフォローする事が出来ます。

### 通知機能
- 他ユーザからのアクション（フォロー・いいね・コメント）をリアルタイムで通知するため、Discord Botとの連携による通知機能を実装しました。


## 技術的に工夫したところ
### ユーザをアプレンティス生のみに絞込むため、Discord APIを使用して登録可能なユーザを限定しました。<br>
他ユーザからのアクションをリアルタイムで通知出来るよう、Botを経由した通知機能を実装しました。

本番環境には CloudWatch を導入し、CPU・メモリ・ディスク使用率などの監視体制を構築。安定運用を支えています。
## ユーザ目線で工夫したところ
- アプレンティス生の「どの教材を選ぶべきか分からない」という悩み、そして「オリジナルプロダクトの要件定義が進まない」という壁をサポートするため、本サービスは教材共有とオリプロ投稿の2機能を軸に設計しています。それぞれが“失敗しづらい選択・企画”を後押しする「学習の心臓部」として機能することを目指しました。
- SNSとしての使いやすさを重視し、投稿・いいね・コメント・フォロー・通知といった機能を一般的なサービスに倣って設計しました。ユーザーが迷わず使えるよう、既存SNSのUI/UXを積極的に参考にしています。
- JavaScriptを活用し、可能な限りページ遷移を発生させない構成とすることで、操作のテンポを向上させました。
