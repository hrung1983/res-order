function addhw(action, id) {
    document.location.href = "hw.setup.ui.php?id=" + action + "&math=" + id;
}

function edithw(action, id) {
    document.location.href = "hw.setup.ui.php?id=" + action + "&math=" + id;
}

function addbrand(action, id) {
    document.location.href = "brand.setup.ui.php?id=" + action + "&math_id=" + id + "&math_id2=''";
}

function editbrand(action, id, id2) {
    document.location.href = "brand.setup.ui.php?id=" + action + "&math_id=" + id2 + "&math_id2=" + id;
}

function linkbrandindex(action, id) {
    document.location.href = "brand.setup.index.php?id=" + action + "&math=" + id;
}

function addbrandui(action, id) {
    document.location.href = "brand.setup.ui.php?id=" + action + "&math=" + id;
}


function linkmodelindex(action, id) {
    document.location.href = "model.setup.index.php?id=" + action + "&math=" + id;
}