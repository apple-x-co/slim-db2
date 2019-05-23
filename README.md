# slim-application

db slim application

local site

`http://localhost/`

## library

Doctrine
https://www.doctrine-project.org/projects/doctrine-orm/en/latest/

採用にあたっての課題

* エンティティの生成で、Namespace を付けるとディレクトリが勝手に生成されてしまうので、生成が面倒。
* DQL が CakePHP や Eloquent に比べて、直感的ではなく、難しい。
* 1:多 のリレーションを同時に取得するときに、 CakePHP や EloquentのWith句(`User::with('userLogs')->get()`) のようにできない。（ぽい）
→ `eager loading` を使えば良さそうだが、難しい・・・