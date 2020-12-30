

// fill data in shema input with data from data list
function fill_input_shema_with_filename_data_list(filename_data_list) {
  var id, value;

  // iterate through filename data list
  for (root_key in filename_data_list) {
    for (index in filename_data_list[root_key]) {

      // open details tag
      document.getElementById("file_details" + index).setAttribute("open", "open");
      for (key in filename_data_list[root_key][index]) {

        // if key of filename data list is flag
        // use different value and id
        // set data in element
        if (key == "checkbox_shema_flag") {
          for (inner_key in filename_data_list[root_key][index][key]) {
            id = filename_data_list[root_key][index][key][inner_key] + index;
            value = filename_data_list[root_key][index][key][inner_key];
            set_data_in_element(id, value);
          }
        }

        // if key of filename data list is not flag
        // create id and value
        // set data in element
        else {
          id = key + index;
          value = filename_data_list[root_key][index][key];
          set_data_in_element(id, value);
        }
      }
    }
  }
}


// set data in element
function set_data_in_element(id, value) {
  var element = document.getElementById(id);

  // if element is checkbox
  // set checked instead of value
  if (element.tagName == "INPUT" && element.getAttribute("type") == "checkbox") {
    element.checked = true;
  }

  // if element is not checkbox
  // set value
  else {
    element.value = value;
  }
}