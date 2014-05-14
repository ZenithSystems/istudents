<style>
  main .container-fluid {
    padding: 0;
    width: 100%;
    margin: auto;
    margin-top: 50px;
    margin-bottom: 40px;
  }
  .rightback {
    overflow: hidden;
    background-color: #E6E9ED;
  }
  .contentback {
    right: 10%;
    background-color: #FFF;
  }
  .leftback {
    right: 80%;
    background-color: #E6E9ED;
  }
  .rightback,
  .contentback,
  .leftback {
    width: 100%;
    float: left;
    position: relative;
  }
  aside.left {
    width: 10%;
  }
  article.center {
    width: 80%;
    padding: 10px;
    padding-top: 20px;
  }
  aside.right {
    width: 10%;
  }
  aside.left,
  article.center,
  aside.right {
    left: 90%;
    float: left;
    overflow: hidden;
    position: relative;
  }
  @media screen and (max-width: 800px) , screen and (resolution: 144dpi) {
    .rightback {
      background-color: #FFF;
    }
    .leftback {
      background-color: #FFF;
    }
    aside.left {
      width: 0;
    }
    article.center {
      width: 100%;
    }
    aside.right {
      width: 0;
    }
  }
  /*
  <!--@media screen and (min-width: 800px) {
    .content {
      width: 55%;
      left: 20%;
    }
  }
  .google-footer-bar {
    background: #FFF;
    position: fixed;
    bottom: 0;
    height: 35px;
    width: 100%;
    border-top: 1px solid #e5e5e5;
    overflow: hidden;
  }
  .footer {
    margin-left: 5%;
    background: #FFF;
    position: fixed;
    padding-top: 7px;
    font-size: .85em;
    white-space: nowrap;
    line-height: 0;
  }
  .footer ul {
    margin-bottom: 44px;
    float: left;
    max-width: 80%;
    padding: 0;
  }
  .footer ul li {
    margin-bottom: 44px;
    color: #737373;
    display: inline;
    padding: 0;
    padding-right: 10px;
  }
  .footer a {
    color: #737373;
  }
  .content {
    margin-top:44px;
    padding: 30px;
    position:fixed;
    background:#FFF;
    height:100%;
  }
  body>.sticky #header .header-bar .icon-logo>span{
    display:inline;
    visibility:inherit;
    color:#FFF;
    padding:2px 4px 2px 4px;
    font-size:13px;
    background:#09F;
    margin-bottom:3px;
  }
  body>.sticky #header .header-bar .icon-logo{
    width:93%;
    z-index:299;
    display:inline;
    height:44px;
    text-align:center;
    position:absolute;
    font-weight:bold;
  }
  @media screen and (min-width: 800px) {
    .content {
      width: 55%;
      left: 20%;
    }
    body > .sticky .warpper #header .header-bar .icon-logo {
      width: 100%;
      text-align: center;
      font-size: 36px;
      font-weight: bold;
    }
    body > .sticky .warpper #header .header-bar .icon-logo > span {
      display: inline;
      visibility: inherit;
      color: #FFF;
      padding: 2px 4px 2px 4px;
      font-size: 13px;
      background: #09F;
      margin-bottom: 3px;
    }
  }
  @media screen and (max-width: 800px) {
    .content {
      width: 100%;
      left: 0;
    }
    body > .sticky .warpper #header .header-bar .icon-logo {
      width: 100%;
      text-align: center;
      font-size: 90px;
      font-weight: bold;
      height: 90px;
    }
    body > .sticky .warpper #header .header-bar .icon-logo > span {
      display: inline;
      visibility: inherit;
      color: #FFF;
      padding: 2px 4px 2px 4px;
      font-size: 13px;
      background: #09F;
      margin-bottom: 3px;
    }
  }-->
</style>