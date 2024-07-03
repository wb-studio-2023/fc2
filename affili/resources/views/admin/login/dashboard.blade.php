@extends('admin.layout')

@section('title', '【eM管理画面】ダッシュボード')

@section('css')
<link rel="stylesheet" href="{{ mix('css/admin/top.css') }}">
@endsection

@section('js')
@endsection

@section('content')
<div id="main">
    <!-- <section id="watched_articles">
        <h2>閲覧数Top5記事</h2>
        <div class="table">
            <table>
                <tbody>
                    <tr>
                        <td rowspan="4" class="head order">1</td>
                        <td class="head">タイトル</td>
                        <td colspan="7">
                            <a href="">
                                タイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトル
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td class="head div_four">閲覧数</td>
                        <td class="body_center div_four">000000</td>
                        <td class="head div_four">いいね</td>
                        <td class="body_center div_four">000000</td>
                        <td class="head div_four">ダミー閲覧数</td>
                        <td class="body_center div_four">000000</td>
                        <td class="head div_four">ダミーいいね</td>
                        <td class="body_center div_four">000000</td>
                    </tr>
                    <tr>
                        <td colspan="1" class="head">材料</td>
                        <td colspan="7">
                            材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、
                        </td>
                    </tr>
                    <tr>
                        <td class="head">カテゴリー</td>
                        <td colspan="2" class="body_center">カテゴリー</td>
                        <td class="head">タグ</td>
                        <td colspan="4">
                            たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="table_separate"></div>

            <table>
                <tbody>
                    <tr>
                        <td rowspan="4" class="head order">1</td>
                        <td class="head">タイトル</td>
                        <td colspan="7">タイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトル</td>
                    </tr>
                    <tr>
                        <td class="head div_four">閲覧数</td>
                        <td class="body_center div_four">000000</td>
                        <td class="head div_four">いいね</td>
                        <td class="body_center div_four">000000</td>
                        <td class="head div_four">ダミー閲覧数</td>
                        <td class="body_center div_four">000000</td>
                        <td class="head div_four">ダミーいいね</td>
                        <td class="body_center div_four">000000</td>
                    </tr>
                    <tr>
                        <td colspan="1" class="head">材料</td>
                        <td colspan="7">材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、</td>
                    </tr>
                    <tr>
                        <td class="head">カテゴリー</td>
                        <td colspan="2" class="body_center">カテゴリー</td>
                        <td class="head">タグ</td>
                        <td colspan="4">たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、</td>
                    </tr>
                </tbody>
            </table>

            <div class="table_separate"></div>

            <table>
                <tbody>
                    <tr>
                        <td rowspan="4" class="head order">1</td>
                        <td class="head">タイトル</td>
                        <td colspan="7">タイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトル</td>
                    </tr>
                    <tr>
                        <td class="head div_four">閲覧数</td>
                        <td class="body_center div_four">000000</td>
                        <td class="head div_four">いいね</td>
                        <td class="body_center div_four">000000</td>
                        <td class="head div_four">ダミー閲覧数</td>
                        <td class="body_center div_four">000000</td>
                        <td class="head div_four">ダミーいいね</td>
                        <td class="body_center div_four">000000</td>
                    </tr>
                    <tr>
                        <td colspan="1" class="head">材料</td>
                        <td colspan="7">材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、</td>
                    </tr>
                    <tr>
                        <td class="head">カテゴリー</td>
                        <td colspan="2" class="body_center">カテゴリー</td>
                        <td class="head">タグ</td>
                        <td colspan="4">たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、</td>
                    </tr>
                </tbody>
            </table>

            <div class="table_separate"></div>

            <table>
                <tbody>
                    <tr>
                        <td rowspan="4" class="head order">1</td>
                        <td class="head">タイトル</td>
                        <td colspan="7">タイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトル</td>
                    </tr>
                    <tr>
                        <td class="head div_four">閲覧数</td>
                        <td class="body_center div_four">000000</td>
                        <td class="head div_four">いいね</td>
                        <td class="body_center div_four">000000</td>
                        <td class="head div_four">ダミー閲覧数</td>
                        <td class="body_center div_four">000000</td>
                        <td class="head div_four">ダミーいいね</td>
                        <td class="body_center div_four">000000</td>
                    </tr>
                    <tr>
                        <td colspan="1" class="head">材料</td>
                        <td colspan="7">材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、</td>
                    </tr>
                    <tr>
                        <td class="head">カテゴリー</td>
                        <td colspan="2" class="body_center">カテゴリー</td>
                        <td class="head">タグ</td>
                        <td colspan="4">たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、</td>
                    </tr>
                </tbody>
            </table>

            <div class="table_separate"></div>

            <table>
                <tbody>
                    <tr>
                        <td rowspan="4" class="head order">1</td>
                        <td class="head">タイトル</td>
                        <td colspan="7">タイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトル</td>
                    </tr>
                    <tr>
                        <td class="head div_four">閲覧数</td>
                        <td class="body_center div_four">000000</td>
                        <td class="head div_four">いいね</td>
                        <td class="body_center div_four">000000</td>
                        <td class="head div_four">ダミー閲覧数</td>
                        <td class="body_center div_four">000000</td>
                        <td class="head div_four">ダミーいいね</td>
                        <td class="body_center div_four">000000</td>
                    </tr>
                    <tr>
                        <td colspan="1" class="head">材料</td>
                        <td colspan="7">材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、</td>
                    </tr>
                    <tr>
                        <td class="head">カテゴリー</td>
                        <td colspan="2" class="body_center">カテゴリー</td>
                        <td class="head">タグ</td>
                        <td colspan="4">たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、</td>
                    </tr>
                </tbody>
            </table>

            <div class="table_separate"></div>

        </div>
    </section>

    <div class="separate"></div>

    <section id="liked_articles">
        <h2>いいねTop5記事</h2>
        <div class="table">
            <table>
                <tbody>
                    <tr>
                        <td rowspan="4" class="head order">1</td>
                        <td class="head">タイトル</td>
                        <td colspan="7">
                            <a href="">
                                タイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトル
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td class="head div_four">閲覧数</td>
                        <td class="body_center div_four">000000</td>
                        <td class="head div_four">いいね</td>
                        <td class="body_center div_four">000000</td>
                        <td class="head div_four">ダミー閲覧数</td>
                        <td class="body_center div_four">000000</td>
                        <td class="head div_four">ダミーいいね</td>
                        <td class="body_center div_four">000000</td>
                    </tr>
                    <tr>
                        <td colspan="1" class="head">材料</td>
                        <td colspan="7">
                            材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、
                        </td>
                    </tr>
                    <tr>
                        <td class="head">カテゴリー</td>
                        <td colspan="2" class="body_center">カテゴリー</td>
                        <td class="head">タグ</td>
                        <td colspan="4">
                            たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="table_separate"></div>

            <table>
                <tbody>
                    <tr>
                        <td rowspan="4" class="head order">1</td>
                        <td class="head">タイトル</td>
                        <td colspan="7">タイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトル</td>
                    </tr>
                    <tr>
                        <td class="head div_four">閲覧数</td>
                        <td class="body_center div_four">000000</td>
                        <td class="head div_four">いいね</td>
                        <td class="body_center div_four">000000</td>
                        <td class="head div_four">ダミー閲覧数</td>
                        <td class="body_center div_four">000000</td>
                        <td class="head div_four">ダミーいいね</td>
                        <td class="body_center div_four">000000</td>
                    </tr>
                    <tr>
                        <td colspan="1" class="head">材料</td>
                        <td colspan="7">材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、</td>
                    </tr>
                    <tr>
                        <td class="head">カテゴリー</td>
                        <td colspan="2" class="body_center">カテゴリー</td>
                        <td class="head">タグ</td>
                        <td colspan="4">たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、</td>
                    </tr>
                </tbody>
            </table>

            <div class="table_separate"></div>

            <table>
                <tbody>
                    <tr>
                        <td rowspan="4" class="head order">1</td>
                        <td class="head">タイトル</td>
                        <td colspan="7">タイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトル</td>
                    </tr>
                    <tr>
                        <td class="head div_four">閲覧数</td>
                        <td class="body_center div_four">000000</td>
                        <td class="head div_four">いいね</td>
                        <td class="body_center div_four">000000</td>
                        <td class="head div_four">ダミー閲覧数</td>
                        <td class="body_center div_four">000000</td>
                        <td class="head div_four">ダミーいいね</td>
                        <td class="body_center div_four">000000</td>
                    </tr>
                    <tr>
                        <td colspan="1" class="head">材料</td>
                        <td colspan="7">材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、</td>
                    </tr>
                    <tr>
                        <td class="head">カテゴリー</td>
                        <td colspan="2" class="body_center">カテゴリー</td>
                        <td class="head">タグ</td>
                        <td colspan="4">たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、</td>
                    </tr>
                </tbody>
            </table>

            <div class="table_separate"></div>

            <table>
                <tbody>
                    <tr>
                        <td rowspan="4" class="head order">1</td>
                        <td class="head">タイトル</td>
                        <td colspan="7">タイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトル</td>
                    </tr>
                    <tr>
                        <td class="head div_four">閲覧数</td>
                        <td class="body_center div_four">000000</td>
                        <td class="head div_four">いいね</td>
                        <td class="body_center div_four">000000</td>
                        <td class="head div_four">ダミー閲覧数</td>
                        <td class="body_center div_four">000000</td>
                        <td class="head div_four">ダミーいいね</td>
                        <td class="body_center div_four">000000</td>
                    </tr>
                    <tr>
                        <td colspan="1" class="head">材料</td>
                        <td colspan="7">材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、</td>
                    </tr>
                    <tr>
                        <td class="head">カテゴリー</td>
                        <td colspan="2" class="body_center">カテゴリー</td>
                        <td class="head">タグ</td>
                        <td colspan="4">たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、</td>
                    </tr>
                </tbody>
            </table>

            <div class="table_separate"></div>

            <table>
                <tbody>
                    <tr>
                        <td rowspan="4" class="head order">1</td>
                        <td class="head">タイトル</td>
                        <td colspan="7">タイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトル</td>
                    </tr>
                    <tr>
                        <td class="head div_four">閲覧数</td>
                        <td class="body_center div_four">000000</td>
                        <td class="head div_four">いいね</td>
                        <td class="body_center div_four">000000</td>
                        <td class="head div_four">ダミー閲覧数</td>
                        <td class="body_center div_four">000000</td>
                        <td class="head div_four">ダミーいいね</td>
                        <td class="body_center div_four">000000</td>
                    </tr>
                    <tr>
                        <td colspan="1" class="head">材料</td>
                        <td colspan="7">材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、材料、</td>
                    </tr>
                    <tr>
                        <td class="head">カテゴリー</td>
                        <td colspan="2" class="body_center">カテゴリー</td>
                        <td class="head">タグ</td>
                        <td colspan="4">たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、たぐ、</td>
                    </tr>
                </tbody>
            </table>

            <div class="table_separate"></div>

        </div>
    </section>

    <div class="separate"></div>

    <section id="watched_parts_direct">
        <h2>閲覧数Top5 -直接検索-</h2>
        <div class="table">
            <table>
                <tr>
                    <td colspan="5" class="head">
                        材料Top5
                    </td>
                </tr>
                <tr>
                    <td class="order">
                        1
                    </td>
                    <td class="order">
                        2
                    </td>
                    <td class="order">
                        3
                    </td>
                    <td class="order">
                        4
                    </td>
                    <td class="order">
                        5
                    </td>
                </tr>
                <tr>
                    <td class="name">
                        材料001
                    </td>
                    <td class="name">
                        材料002
                    </td>
                    <td class="name">
                        材料002
                    </td>
                    <td class="name">
                        材料002
                    </td>
                    <td class="name">
                        材料002
                    </td>
                </tr>
                <tr>
                    <td colspan="5" class="head">
                        カテゴリーTop5
                    </td>
                </tr>
                <tr>
                    <td class="order">
                        1
                    </td>
                    <td class="order">
                        2
                    </td>
                    <td class="order">
                        3
                    </td>
                    <td class="order">
                        4
                    </td>
                    <td class="order">
                        5
                    </td>
                </tr>
                <tr>
                    <td class="name">
                        カテゴリー001
                    </td>
                    <td class="name">
                        カテゴリー002
                    </td>
                    <td class="name">
                        カテゴリー002
                    </td>
                    <td class="name">
                        カテゴリー002
                    </td>
                    <td class="name">
                        カテゴリー002
                    </td>
                </tr>
                <tr>
                    <td colspan="5" class="head">
                        タグTop5
                    </td>
                </tr>
                <tr>
                    <td class="order">
                        1
                    </td>
                    <td class="order">
                        2
                    </td>
                    <td class="order">
                        3
                    </td>
                    <td class="order">
                        4
                    </td>
                    <td class="order">
                        5
                    </td>
                </tr>
                <tr>
                    <td class="name">
                        タグ001
                    </td>
                    <td class="name">
                        タグ002
                    </td>
                    <td class="name">
                        タグ002
                    </td>
                    <td class="name">
                        タグ002
                    </td>
                    <td class="name">
                        タグ002
                    </td>
                </tr>
            </table>

            <div class="table_separate"></div>

        </div>
    </section>

    <div class="separate"></div>

    <section id="watched_parts_included">
        <h2>閲覧数Top5 -記事に含まれるやつ-</h2>
        <div class="table">
            <table>
                <tr>
                    <td colspan="5" class="head">
                        材料Top5
                    </td>
                </tr>
                <tr>
                    <td class="order">
                        1
                    </td>
                    <td class="order">
                        2
                    </td>
                    <td class="order">
                        3
                    </td>
                    <td class="order">
                        4
                    </td>
                    <td class="order">
                        5
                    </td>
                </tr>
                <tr>
                    <td class="name">
                        材料001
                    </td>
                    <td class="name">
                        材料002
                    </td>
                    <td class="name">
                        材料002
                    </td>
                    <td class="name">
                        材料002
                    </td>
                    <td class="name">
                        材料002
                    </td>
                </tr>
                <tr>
                    <td colspan="5" class="head">
                        カテゴリーTop5
                    </td>
                </tr>
                <tr>
                    <td class="order">
                        1
                    </td>
                    <td class="order">
                        2
                    </td>
                    <td class="order">
                        3
                    </td>
                    <td class="order">
                        4
                    </td>
                    <td class="order">
                        5
                    </td>
                </tr>
                <tr>
                    <td class="name">
                        カテゴリー001
                    </td>
                    <td class="name">
                        カテゴリー002
                    </td>
                    <td class="name">
                        カテゴリー002
                    </td>
                    <td class="name">
                        カテゴリー002
                    </td>
                    <td class="name">
                        カテゴリー002
                    </td>
                </tr>
                <tr>
                    <td colspan="5" class="head">
                        タグTop5
                    </td>
                </tr>
                <tr>
                    <td class="order">
                        1
                    </td>
                    <td class="order">
                        2
                    </td>
                    <td class="order">
                        3
                    </td>
                    <td class="order">
                        4
                    </td>
                    <td class="order">
                        5
                    </td>
                </tr>
                <tr>
                    <td class="name">
                        タグ001
                    </td>
                    <td class="name">
                        タグ002
                    </td>
                    <td class="name">
                        タグ002
                    </td>
                    <td class="name">
                        タグ002
                    </td>
                    <td class="name">
                        タグ002
                    </td>
                </tr>
            </table>

            <div class="table_separate"></div>

        </div>
    </section>
 -->
    <div>
        のちのち「バッチのlog」とか「売り上げ」入れたい
    </div>
</div>
@endsection