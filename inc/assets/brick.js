function categoryIcon(category,icon){
    if(!icon || !category || !window.wp.element) return;
    var k = [];
    if(icon.path.attributes) k.push(window.wp.element.createElement('path',icon.path.attributes));
    else for (let i = 0; i < icon.path.length; i++) k.push(window.wp.element.createElement('path',icon.path[i].attributes));
    icon = window.wp.element.createElement('svg',icon.attributes,k);
    return window.wp.blocks.updateCategory(category,{icon: icon});
}