
// fill data in shema input with data from data list
function fill_input_shema_with_filename_data_list(filename_data_list) {
  var id, value;
  root_key = "file_data_list";

  for (var array_index in filename_data_list[root_key]) {

    var filename_data = filename_data_list[root_key][array_index];
    var path = filename_data["path_source"];
    var index = array_index;


    // open details tag
    if (document.getElementById("file_details" + index)) {
      index = get_index_of_filename_input_by_path(path);
      document.getElementById("file_details" + index).setAttribute("open", "open");
    }

    // iterate through filename data list
    for (key in filename_data) {

      if(key == "error") {
        document.getElementById("file_details" + index).className += "error";
        continue;
      }

      // if key of filename data list is checkbox (flag option)
      // use different value and id
      // set data in checkbox elementfilename_data_lis
      if (typeof filename_data[key] == 'object') {
        for (inner_key in filename_data[key]) {
          id = filename_data[key][inner_key];
          if(key == "Filename_Shema_Flag"){
            id += index;
          }
          value = filename_data[key][inner_key];
          set_data_in_element(id, value);
        }
      }

      // if key of filename data list is not flag
      // create id and value
      // set data in element
      else {
        value = filename_data[key];
        id = key + index;
        set_data_in_element(id, value);
      }
    }
  }
}


// get index of filename input in ui by it's path (value of textfield)
function get_index_of_filename_input_by_path(path) {
  var class_name = "path_source";
  var elements = document.getElementsByClassName(class_name)
  var f;
  for (f = 0; f < elements.length; f++) {
    if (elements[f].getAttribute("value") == path) {
      return f;
    }
  }
  return 0;
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


function highlight_shema_input_element(index) {

  // add class
  document.getElementById("file_details" + index).classList.add("file_shema_input_highlight");
}


// disable all elements by a class name if an checkbox element with a id is not checked
function disable_input_by_class_name_if_source_element_is_not_checked(id_source_element, class_element_to_disable) {
  all_elements = document.getElementsByClassName(class_element_to_disable);
  source = document.getElementById(id_source_element);
  for (f = 0; f < all_elements.length; f++) {
    if (source.checked) {
      all_elements[f].removeAttribute("disabled");
    }
    else {
      all_elements[f].setAttribute("disabled", "disabled");
    }
  }
}


// disable a element by a id name if an checkbox element with a id is not checked
function disable_input_by_id_name_if_source_element_is_not_checked(id_source_element, id_element_to_disable) {
  element = document.getElementById(id_element_to_disable);
  source = document.getElementById(id_source_element);
  if (source.checked) {
    element.removeAttribute("disabled");
  }
  else {
    element.setAttribute("disabled", "disabled");
  }
}


// disable and hide all elements by a class name if an checkbox element with a id is not checked
function disable_and_hide_input_by_class_name_if_source_element_is_not_checked(id_source_element, class_element_to_disable) {
  all_elements = document.getElementsByClassName(class_element_to_disable);
  source = document.getElementById(id_source_element);
  for (f = 0; f < all_elements.length; f++) {
    if (source.checked) {
      all_elements[f].removeAttribute("disabled");
      all_elements[f].removeAttribute("required");
      all_elements[f].style.display = "block";
    }
    else {
      all_elements[f].setAttribute("disabled", "disabled");
      all_elements[f].setAttribute("required", "required");
      all_elements[f].style.display = "none";
    }
  }
}


// copy text of parameter element to clipboard on button click
function copyToClipboard(element) {
  var $temp = $("<input>");
  $("body").append($temp);
  $temp.val($(element).text()).select();
  document.execCommand("copy");
  $temp.remove();
}


// add additional search input onclick on plus button
function add_search_input_with_plus_button(element){
  var parent = element.closest('.additional_input_root')
  var parent_clone = parent.clone();
  // var checkbox = parent.siblings('input[type=checkbox]:first');
  // var checkbox_clone = checkbox.clone();
  // checkbox_clone.insertAfter(parent);
  parent_clone.insertAfter(parent);
}

// remove additional search input onclick on minus button
function remove_search_input_with_minus_button(element){
  class_name = element.siblings('input:first, textarea:first, select:nth-child(2)').attr('class').split(/\s+/)[0];
  if($('.'+class_name).length > 1){
    var parent = element.closest('.additional_input_root');
    parent.remove();
    // var checkbox = parent.siblings('input[type=checkbox]:first');
    // var checkbox_clone = checkbox.clone();
    // checkbox_clone.insertAfter(parent);
  }
}