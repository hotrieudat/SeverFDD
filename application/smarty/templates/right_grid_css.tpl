<style>
#left_box{
    float:left;
    width: 60%; /* IE8,9 用fallback*/
    width: calc(70% - 60px);
    margin:0;
    margin-left: 10px;
}

#right_box {
    float: right;
    width: 30%;
    height: calc(100vh - 165px);
    margin: 0;
    padding: 20px;
    background-color: #eeeeee;
}

#right_grid_box {
    background-color: #ffffff;
    padding:10px;
    width:100%;
    height:100%;
    box-sizing: border-box;
}
#pname{
    border-style: solid ;
    border-width: 1px;
    padding: 10px 5px 10px 20px;
    width:980px;
    font-size= 40px ;
    text-align: center;
}
#pmb{
    margin:10px;
    margin-left:5px;
    padding: 0 5px 10px 0;
    font-size : 14px;
    font-weight: bold;
    color:#333;
}
#btn{
    margin:10px;
}

#user_grid_box > .pagination,
#public_groups_grid_box > .pagination {
    width: 90%;
    height: auto;
    padding-top: 15px;
}

.contents_inner {
    padding-top: 0;
    padding-left: 8px;
}
.contents{
    padding-top:0;
}

#member_grid_box,
#gridbox,
#user_grid_box,
#public_groups_grid_box
{
    width:  expression((parseInt(this.parentNode.offsetWidth)-20)+'px');
    height: 450px;
    /*height:calc(100% - 160px);;*/
}

#ex_pagination {
    width: auto;
    height: 55px;
    position: static;
    left: 0;
    bottom: 22px;
    right: 0px;
    padding: 0;
    text-align: center;
    border-collapse: separate;
    border-spacing: 10px 0;
    background-color: white;
    margin: 30px 0 0 30px;
}

#ex_pagination ul li {
    display: table-cell;
    font-size: 13px;
    width: 100px;
    height: 35px;
    border: 1px solid #acacac;
    /*color: #0972AF;*/
    vertical-align: middle;
}

#ex_pagination ul li.pagenumber {
    width: 35px;
}

div.gridbox_dhx_web.gridbox table.obj.row20px tr td img {
    display: inline;
}
</style>