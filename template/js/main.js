Vue.component('vueHeader', {
    props:['h1mag'],
    template: `
      <header  class="bg-primary text-white py-3">
        <div class="container text-center">
          <h1>{{h1mag}}</h1>
        </div>
      </header>
    `
  });
  Vue.component('vueList', {
    props:['text', 'url'],
    template:'#vueList'
  });
  
  var vm = new Vue({
    el:'#app',
    data:{
      h1mag:'Bootstrap 列表',
      list:[
        {text:'使用 popover',url:'QPVOWp'},
        {text:'Text Neon Glow 文字霓虹燈 map 寫法',url:'arvZNm'},
        {text:'新增 shadow-color',url:'oRgaVe'},
        {text:'錯誤訊息顯示 alert',url:'ywymex'},
        {text:'0 - n timer',url:'XGWyww?editors=1100'},
        {text:'Card 卡片的用法',url:'PxGvqr'},
        {text:'card hover 放大',url:'aPwNJV'},
        {text:'仿製 Adoda 彈跳視窗 5秒 彈跳視窗',url:'pqERoM'},
        {text:' jQuery(document).ready()  彈跳視窗',url:'xQZoML'},
        {text:'progress 加動畫',url:'gQgawP?editors=1010'},
        {text:'navbar :hover',url:'ELezLP?editors=1010'},
        {text:'密碼強度 (password strength)',url:'zraOjX'},
        {text:'連續彈跳選單',url:'pjXPRv?editors=1000'},
        {text:'nav top & go to top',url:'RYZPJB?editors=1010'},
        {text:'Table overflow-y 卷軸',url:'JGgmjM?editors=1100'},
        {text:'改寫 bootstrap-easy-sidebar',url:'bEKZzO?editors=1010'},
        {text:'上方錯誤訊息',url:'ygLQXd?editors=1010'},
        {text:'sign in / registered  登入與註冊',url:'bpjBMm'},
        {text:'Datepicker ',url:'aWYJwp'},
        {text:'carousel 改寫',url:'JGbVdm'},
        {text:'解決 input 手機版 使用 -webkit-appearance: none; 文字向下的問題',url:'vpvmyo?editors=1010'},
        {text:'Callouts map 用法',url:'wLBPby?editors=1100'},
        {text:'Alert',url:'QyreQE?editors=1010'},
        {text:'改寫 Login ',url:'NGmZLX?editors=1100'},
        {text:'Toasts',url:'orgpeW?editors=1000'},
        {text:'套用 Datepicker',url:'rEdXPj?editors=1010'},
        {text:'簡易 step',url:'GRKZrgv?editors=1000'},
        {text:'Calendar 樣式設計',url:'MWgGzaJ'},
        {text:'Rwd Table',url:'YwoEEZ?editors=1010'},
        {text:'Collapse 加上文字與動畫',url:'voYYpz'},
        {text:'modal-bottom',url:'RwbaKNV?editors=0100'},
        {text:'數字從 0 - n',url:'NWqyLXm?editors=1010'},
        {text:'商品購物的樣式 shopping cart',url:'JqYQER'},
        {text:'figure hover img',url:'KKpQxjd?editors=1100'},
        {text:'Card shadow',url:'JjYjdzY?editors=1000'},
        {text:'Card Modern',url:'yLYvxvo?editors=1100'},
        {text:'資料顯示版面設計',url:'LYpeyMy'},
        {text:'checkbox hide table',url:'LYYZvWq'},
        {text:'加入書籤',url:'wvwbZNr'},
        {text:'input-group on style',url:'BXYJYW'},
        {text:'block card',url:'YzwjMJb'},
        {text:'文章 product #2',url:'pobEZNy?editors=1010'},
        {text:'badge tail 魚尾巴',url:'qBNgoOX?editors=1100'},
        {text:'產品列表 product #2',url:'KKMJBgw?editors=0100'},
        {text:'產品列表 product #1',url:'ZEOVgqm'},
        {text:'文章 product #1',url:'mdEvQBQ?editors=0100'},
        {text:'Modal Animated Tick',url:'vYKMEQB'},
        {text:'產品列表 product #3',url:'WNxmLVE?editors=1100'},
        {text:'折疊 Collapse style',url:'BaLarOL?editors=0100'},
        {text:'看更多 readmore rendered #1',url:'rNMaYqJ?editors=0110'},
        {text:'新聞 post news  #1',url:'LYREqjW?editors=0110'},
        {text:'新聞 post news  #2',url:'RwGVyRw'},
        {text:'img item 照片描述 #1',url:'OJRzpod?editors=1100'},
        {text:'text hover color',url:'poPKwMB?editors=1100'},
        {text:'改寫 custom-switch',url:'poWyzGR?editors=0100'},
        {text:'',url:''},
        {text:'',url:''},
      ]
    }
  });