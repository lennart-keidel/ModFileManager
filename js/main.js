function open_first_details_slot(){
  // open details tag
  if (document.getElementById("file_details0")) {
    document.getElementById("file_details0").setAttribute("open", "open");
  }
}


// fill data in search shema input with data from data list
function fill_search_input_shema_with_filename_data_list(filename_data_list) {

  var id, value;
  root_key = "file_data_list";
  root_sub_key = 1000000;
  operand_key = "operand";
  value_key = "value";
  enable_search_shema_key = "enable_search_shema";
  search_shema_connector_key = "search_shema_connector";

  if(!filename_data_list[root_key]){
    return;
  }
  var operand_array = filename_data_list[root_key][root_sub_key][operand_key];
  var value_array = filename_data_list[root_key][root_sub_key][value_key];
  var enable_search_shema_array = filename_data_list[root_key][root_sub_key][enable_search_shema_key];
  var search_shema_connector = filename_data_list[root_key][root_sub_key][search_shema_connector_key];
  var search_shema_connector_element = $("#"+search_shema_connector_key+root_sub_key);

  // set search shema connetor value
  search_shema_connector_element.val(search_shema_connector);

  // set enable search shema checkboxes
  for(var index in enable_search_shema_array){
    document.getElementById(enable_search_shema_array[index]).checked = true;
  }

  // iterate through values
  // set operands
  // set values
  for (var class_id in value_array){
    // if(class_id != "Filename_Shema_Flag"){
      var w = value_array[class_id].length;
      while(w-- > 1){
        add_search_input_with_plus_button($("[name*="+operand_key+"]."+class_id+root_sub_key)[0]);
      }
    // }
    for (var index in value_array[class_id]){
      var operand = operand_array[class_id][index];
      var value = value_array[class_id][index];
      if(class_id == "Filename_Shema_Flag"){
        value_element = $("[value*="+value+"]."+class_id+root_sub_key);
        operand_element = $(value_element).siblings("[name*="+operand_key+"]."+class_id+root_sub_key);
        index = 0;
      }

      else {
        var operand_element = $("[name*="+operand_key+"]."+class_id+root_sub_key);
        var value_element = $("[name*="+value_key+"]."+class_id+root_sub_key);
      }

      $(operand_element[index]).val(operand);
      if (value_element[index].tagName == "INPUT" && $(value_element[index]).attr("type") == "checkbox"){
        $(value_element[index]).attr("checked","true");
      }
      else {
        $(value_element[index]).val(value);
      }
    }
  }
}


// fill data in search shema input with data from data list
function fill_fast_edit_input_shema_with_filename_data_list(filename_data_list) {

  var class_name, value;
  root_key = "fast_edit";

  for (var array_index in filename_data_list[root_key]) {

    var filename_data = filename_data_list[root_key][array_index];
    var path = filename_data["path_source"];
    var index = array_index;


    // // open details tag
    // if (document.getElementById("file_details" + index)) {
    //   index = get_index_of_filename_input_by_path(path);
    //   document.getElementById("file_details" + index).setAttribute("open", "open");
    // }

    // iterate through filename data list
    for (key in filename_data) {

      // if(key == "error") {
      //   document.getElementById("file_details" + index).className += "error";
      //   continue;
      // }

      // if key of filename data list is checkbox (flag option)
      // use different value and class_name
      // set data in checkbox element
      if (typeof filename_data[key] == 'object') {
        for (inner_key in filename_data[key]) {
          class_name = filename_data[key][inner_key];
          if(key == "Filename_Shema_Flag"){
            class_name += index;
          }
          value = filename_data[key][inner_key];
          if(key == "Sub_Data_Flag_Depends_On_Expansion" || key == "Sub_Data_Flag_Depends_On_Content"){
            if(inner_key > 0){
              add_search_input_with_plus_button($("."+key+array_index)[inner_key-1]);
            }
            set_data_in_element($("."+key+array_index)[inner_key], value);
          }
          set_data_in_element_by_class(class_name, value);
        }
      }

      // if key of filename data list is not flag
      // create class_name and value
      // set data in element
      else {
        value = filename_data[key];
        class_name = key + index;
        set_data_in_element_by_class(class_name, value);
      }
    }
  }
}


// fill data in shema input with data from data list
function fill_input_shema_with_filename_data_list(filename_data_list) {
  var class_name, value;
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
      // use different value and class_name
      // set data in checkbox element filename_data_list
      if (typeof filename_data[key] == 'object') {
        for (inner_key in filename_data[key]) {
          class_name = filename_data[key][inner_key];
          if(key == "Filename_Shema_Flag"){
            class_name += index;
          }
          value = filename_data[key][inner_key];
          if(key == "Sub_Data_Flag_Depends_On_Expansion" || key == "Sub_Data_Flag_Depends_On_Content"){
            if(inner_key > 0){
              add_search_input_with_plus_button($("."+key+array_index)[inner_key-1]);
            }
            set_data_in_element($("."+key+array_index)[inner_key], value);
          }
          set_data_in_element_by_class(class_name, value);
        }
      }

      // if key of filename data list is not flag
      // create class_name and value
      // set data in element
      else {
        value = filename_data[key];
        class_name = key + index;
        set_data_in_element_by_class(class_name, value);
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
function set_data_in_element_by_id(id, value) {
  var element = document.getElementById(id);
  set_data_in_element(element, value);
}


// set data in element
function set_data_in_element_by_class(class_name, value) {
  var element_array = document.getElementsByClassName(class_name);
  for(index in element_array){
    element = element_array[index];
    set_data_in_element(element, value);
  }

}


function set_data_in_element(element, value) {

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
  var all_elements = $("."+class_element_to_disable);
  var source = document.getElementById(id_source_element);

  // anonymus function for disabeling
  var disable = function(source, element){
    if (source.checked) {
      element.removeAttr("disabled");
    }
    else {
      element.attr("disabled", true);
    }
  };

  // disable all elments with the class and it's child-input-elements
  all_elements.each(function(){
    disable(source, $(this));
    $(this).find("input, select, textarea, button").each(function(){
      if($(this).css("display") != "none"){
        disable(source, $(this));
      }
    });
  });
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
      // all_elements[f].removeAttribute("required");
      all_elements[f].style.display = "block";
    }
    else {
      all_elements[f].setAttribute("disabled", "disabled");
      // all_elements[f].setAttribute("required", "required");
      all_elements[f].style.display = "none";
    }
  }
}


// disable and hide all elements by a class name if an checkbox element with a id is not checked
function disable_and_hide_input_by_class_name_if_source_element_is_not_selected(id_source_element, expected_value, class_elements_to_disable) {
  all_elements = document.getElementsByClassName(class_elements_to_disable);
  source = document.getElementById(id_source_element);
  for (f = 0; f < all_elements.length; f++) {
    if(source.value == expected_value){
      all_elements[f].removeAttribute("disabled");
      // all_elements[f].setAttribute("required", "required");
      all_elements[f].style.display = "block";
    }
    else {
      all_elements[f].setAttribute("disabled", "disabled");
      // all_elements[f].removeAttribute("required");
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
  var parent = element.closest('.additional_input_root');
  var parent_clone = $(parent).clone();
  var parent_clone_children = parent_clone.children("input:first, textarea:first, select:nth-child(2)");

  // remove value of clone
  parent_clone_children.val("");

  // add prefix to child id
  parent_clone_children.attr("id", "additional_input__"+parent_clone_children.attr("id"));

  // insert clone
  parent_clone.insertAfter(parent);
}

// remove additional search input onclick on minus button
function remove_search_input_with_minus_button(element){
  class_name = element.siblings('input:first, textarea:first, select:nth-child(2)').attr('class').split(/\s+/)[0];
  if($('.'+class_name).length > 1){
    var parent = element.closest('.additional_input_root');
    var class_names = parent.attr("class").replaceAll(" ",".");

    // don't remove last element
    if($("."+class_names).length > 1){
      parent.remove();
    }
  }
}

//
function copy_data_from_fast_edit_form_into_file_input_form(parent_form_source, parent_form_target, override_existing_data){
  var all_elements_source = $(parent_form_source+" input, "+parent_form_source+" select, "+parent_form_source+" textarea");
  var previous_element;

  all_elements_source.each(function(){
    var source_value = this.value;
    var source_checked = this.checked;
    var source_type = this.getAttribute("type");
    if(source_value != undefined && source_type!="submit"){
      var source_id = remove_trailing_index_from_name(this.id);
      var is_additional_input = source_id.includes("additional_input__") === true;
      var target_element = $(parent_form_target+" "+"*[id^="+source_id+"]");
      if(is_additional_input === true && target_element.length === 0){
        add_search_input_with_plus_button(previous_element);
        target_element = $(parent_form_target+" "+"*[id^="+source_id+"]");
      }
      var target_checked = target_element.get(0).checked;
      if(source_type == "checkbox"){
        if(override_existing_data === false ? source_checked == true && target_checked == false : source_checked != target_checked){
          target_element.trigger("click");
        }
      }
      else {
        if(override_existing_data === false ? !target_element.val() : source_value){
          target_element.val(source_value);
          target_element.trigger("click");
        }
      }
    }
    previous_element = target_element;
  });
}


function remove_trailing_index_from_name(string_name){
  return string_name.replace(/\d+$/, "");
}


document.addEventListener("DOMContentLoaded", function(){
  setTimeout(function(){
    if($("#Filename_Shema_Link0").val() === ''){
      copy_data_from_fast_edit_form_into_file_input_form('#shema_fast_edit','#shema_input0', true);
      $("#Filename_Shema_Description0").focus();
    }
  },100);
});