<form method="post" action=".">

  <select name="select_shema_categorie">
    <option id="option_core_mod">Core Mod</option>
    <option id="option_default_replacemant">Default Replacemant</option>
    <option id="option_tuning">Tuning</option>
  </select>
  <input type="text" name="text_shema_description">
  <input type="url" name="url_shema_link">
  <input type="date" name="date_shema_installation_date">
  <select name="select_shema_flag">
    <option id="option_overrides">muss in Overrides-Ordner installiert werden</option>
    <option id="option_packages">muss in Packages-Ordner installiert werden</option>
    <option id="option_depends_on_mod">abhängig von anderem Mod, CC, Store oder ähnlichem</option>
  </select>
  <input type="url" name="url_shema_flag_option_depends_on_mod_data">


  <input type="submit" value="absenden">

  <?php
    if(isset($_POST) && !empty($_POST)){
      var_dump($_POST);
    }
  ?>
</form>