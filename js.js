function $(str) {
  return document.querySelector(str);
}
// no jQuery, so do stuff like this
HTMLElement.prototype.html = function(str) {
  if (str == null) {
    return this.innerHTML;
  } else {
    this.innerHTML = str;
    return this;
  }
}
HTMLElement.prototype.css = function(obj) {
    var str = '';
    /*arr = Object.keys(obj).map(function(key) {return key + ":" + obj[key]});
    for (var i in arr) {
      str += i + ";";
      console.log(i + ";");
    }*/
  for (i = 0; i < obj.length; i++) {
    str += obj[i] + ";";
  }
    this.style.cssText += str;
  return this;
}
HTMLElement.prototype.attr = function(attr, str) {
  this.setAttribute(attr, str);
  return this;
}

function log(m) {
  var node = document.createElement('p');
  var text = document.createTextNode(m);
  node.appendChild(text);
  $('body').appendChild(node);
}