<form method="post" action=".">

  <select name="select_shema_categorie">
    <option id="option_core_mod">Core Mod</option value="option_core_mod">Core Mod</option>
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

  <select name="select_shema_patch_level">
    <option id="option_169" value="1.69">1.69</option>
    <option id="option_167" value="1.67">1.67</option>
    <option id="option_166" value="1.66">1.66</option>
  </select>

  <input type="checkbox" name="checkbox_shema_flag[]" id="option_install_in_overrides" value="option_install_in_overrides">
  <label for="option_install_in_overrides">muss in Overrides-Ordner installiert werden</label>

  <input type="checkbox" name="checkbox_shema_flag[]" id="option_install_in_packages" value="option_install_in_packages">
  <label for="option_install_in_packages">muss in Packages-Ordner installiert werden</label>

  <input type="checkbox" name="checkbox_shema_flag[]" id="option_depends_on_content" value="option_depends_on_content">
  <label for="option_depends_on_content">abhängig von anderem Mod, CC, Store oder ähnlichem</label>

  <input type="checkbox" name="checkbox_shema_flag[]" id="option_depends_on_expansion" value="option_depends_on_expansion">
  <label for="option_depends_on_expansion">abhängig von Erweiterungspack oder Accessoirepack</label>

  <input type="checkbox" name="checkbox_shema_flag[]" id="option_is_essential" value="option_is_essential">
  <label for="option_is_essential">gehört zu den absolut wichtigsten Mods/CC, die immer installiert sein sollen</label>

  <input type="url" name="url_flag_data_depends_on_content" disabled>

  <select name="select_flag_data_depends_on_expansion" disabled>
    <option id="option_ep01">Reiseabenteuer</option>
    <option id="option_ep02">Traumkarrieren</option>
    <option id="option_ep03">Late Night</option>
    <option id="option_ep04">Lebensfreude</option>
    <option id="option_ep05">Einfach Tierisch</option>
    <option id="option_ep06">Showtime</option>
    <option id="option_ep07">Supernatural</option>
    <option id="option_ep08">Jahreszeiten</option>
    <option id="option_ep09">Wildes Studentenleben</option>
    <option id="option_ep10">Inselparadies</option>
    <option id="option_ep11">Into The Future</option>

    <option id="option_sp01">Luxus Accessoires</option>
    <option id="option_sp02">Gib Gas-Luxus Accessoires</option>
    <option id="option_sp03">Design Garten Accessoires</option>
    <option id="option_sp04">Stadt Accessoires</option>
    <option id="option_sp05">Traumsuite Accessoires</option>
    <option id="option_sp06">Katy Perry Süße Welt</option>
    <option id="option_sp07">Diesel Accessoires</option>
    <option id="option_sp08">70er, 80er & 90er Accessoires</option>
    <option id="option_sp09">Movie Accessoires</option>
  </select>

  <input type="submit" value="absenden">

  <?php
    if(isset($_POST) && !empty($_POST)){
      var_dump($_POST);
    }
  ?>
</form>