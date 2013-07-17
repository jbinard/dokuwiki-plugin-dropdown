dokuwiki-plugin-dropdown
========================

Plugin to create dropdown menus with javascript for Dokuwiki.

To create a menu, use the following syntax : 

```
<dropdown>
  <lvl1 "name of your menu">Your content</lvl1>
</dropdown>
```

Place your links and subcategories inside.
Links must be placed in the form of an unordered list.

Example :

```
<dropdown>
  * [[a direct link]]
  <lvl1 "category 1">
    * [[a link]]
    <lvl2 "subcategory">
      * [[an other link]]
      <lvl3 "sub-subcategory">
        * [[a link]]
      </lvl3>
    </lvl2>
  </lvl1>
</dropdown>
```
