<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Dashboard | Pos</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- App favicon -->
  <link rel="shortcut icon" href="{{asset('backend/assets/icons/favicon.png')}}" type="image/x-icon" />

  <!-- Bootstrap Css -->
  <link href="{{asset('backend/assets/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />

  <!-- Fontawesome link -->
  <link href="{{asset('backend/assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />

  <!-- Link Swiper's CSS -->
  <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

  <!-- CSS Link-->
  <link href="./assets/css/pos.css" id="app-style" rel="stylesheet" type="text/css" />
  <link href="./assets/css/create-payment-modal.css" id="app-style" rel="stylesheet" type="text/css" />
</head>

<body>
  <section id="pos-main">
    <div class="row flex-column-reverse flex-lg-row">
      <div class="col-lg-7">
        <!-- Navbar Start -->
        <nav id="navbar">
          <div class="nav-wrapper">
            <div class="nav_back_btn">
              <a href="{{url('admin-dashboard-invoice')}}"><i class="fa-solid fa-arrow-left nevbar-back-icon"></i><span
                  class="nav_back_text">Back to Dashboard</span></a>
            </div>
            <div class="nav-logo">
              <svg width="235" height="66" viewBox="0 0 235 66" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                  d="M31.5043 12.1989L29.4361 13.0606C28.5744 -3.48481 17.5441 -1.76133 14.2695 16.8523L12.0289 17.714C14.5942 2.57869 22.887 -3.58358 27.885 2.06889C33.3347 -0.886685 38.2258 2.71972 39.0876 11.1648C38.1921 9.92557 37.6239 9.39999 36.5024 8.75191C35.6406 2.06889 31.7839 1.97627 28.974 3.58146C30.1587 5.57882 31.0592 8.43328 31.5043 12.1989Z"
                  fill="#004F88" />
                <path
                  d="M25.5325 4.10095C22.172 9.36544 20.8071 13.1579 19.4399 19.9924L21.5081 20.8541C22.3037 13.7959 23.6308 10.264 26.5907 5.54405C26.752 5.28676 26.7848 4.96132 26.6385 4.6952C26.4224 4.3024 26.205 4.09083 25.8442 3.9768C25.7257 3.93935 25.5993 3.99621 25.5325 4.10095Z"
                  fill="#004F88" />
                <path
                  d="M14.0971 57.5264L2.28029 55.163C1.6562 55.0382 1.23594 54.4506 1.31945 53.8197L5.72735 20.5155C5.78692 20.0654 6.0938 19.6867 6.52178 19.5352L14.0971 16.8522L17.027 18.5757L23.5763 35.6382H26.3339L26.8309 14.5943C26.8429 14.0872 27.1703 13.6416 27.6506 13.4786L36.5024 10.4753L34.0979 61.1421C34.0935 61.2346 34.0076 61.3014 33.9169 61.2829L23.921 59.2498L16.51 40.981H14.0971V57.5264Z"
                  fill="url(#paint0_linear_217_2180)" />
                <path
                  d="M40.6387 14.267L36.5024 10.5132L34.0895 61.1835L42.8792 58.2158L50.9261 57.3217C51.6119 57.2455 52.0948 56.6113 51.9857 55.9299L45.4611 15.1508C45.3646 14.5478 44.8335 14.1116 44.2233 14.1342L40.6387 14.267Z"
                  fill="#008AEE" />
                <path d="M24.5337 22.2695L17.027 18.6136L23.64 35.8485H26.6785V26.9699L24.5337 22.2695Z"
                  fill="#008AEE" />
                <path d="M16.5099 40.981H14.097V57.5642L22.5421 55.6305L16.5099 40.981Z" fill="#008AEE" />
                <path
                  d="M41.8452 51.322L34.6066 60.6288L42.7042 56.6362L51.3243 56.8371L43.224 50.9773L41.3281 14.6118H40.6388L41.8452 51.322Z"
                  fill="#004F88" />
                <path
                  d="M34.1001 64.0056L0.478583 56.8647C0.290694 56.8248 0.11377 56.9681 0.11377 57.1602V58.506C0.11377 58.6486 0.21355 58.7718 0.353076 58.8014L34.1722 65.9843C34.221 65.9946 34.2715 65.9928 34.3194 65.9788L54.2668 60.1732C54.3958 60.1357 54.4845 60.0175 54.4845 59.8832V58.6972C54.4845 58.4967 54.2928 58.3519 54.1 58.4066L34.3904 63.9958C34.2959 64.0226 34.1963 64.026 34.1001 64.0056Z"
                  fill="url(#paint1_linear_217_2180)" />
                <path class="nexus_text_color"
                  d="M77.4098 48.6865H71.8781L62.6261 34.6791V48.6865H57.0943V25.9771H62.6261L71.8781 40.0492V25.9771H77.4098V48.6865ZM86.9515 30.409V35.0026H94.3595V39.2728H86.9515V44.2546H95.33V48.6865H81.4197V25.9771H95.33V30.409H86.9515ZM112.832 48.6865L108.206 41.7314L104.13 48.6865H97.8538L105.132 37.1377L97.692 25.9771H104.13L108.691 32.8352L112.702 25.9771H118.978L111.764 37.4289L119.269 48.6865H112.832ZM127.481 25.9771V39.5639C127.481 40.9226 127.815 41.9686 128.484 42.7018C129.152 43.4351 130.134 43.8017 131.428 43.8017C132.722 43.8017 133.714 43.4351 134.404 42.7018C135.094 41.9686 135.439 40.9226 135.439 39.5639V25.9771H140.971V39.5316C140.971 41.5588 140.539 43.2734 139.677 44.6752C138.814 46.077 137.65 47.1337 136.183 47.8454C134.738 48.5571 133.121 48.913 131.331 48.913C129.541 48.913 127.934 48.5679 126.51 47.8778C125.109 47.1661 123.998 46.1093 123.178 44.7075C122.359 43.2841 121.949 41.5588 121.949 39.5316V25.9771H127.481ZM153.072 48.913C151.411 48.913 149.923 48.6434 148.608 48.1042C147.292 47.5651 146.235 46.7671 145.438 45.7104C144.661 44.6536 144.251 43.3812 144.208 41.8931H150.096C150.182 42.7342 150.473 43.3812 150.969 43.8341C151.465 44.2654 152.112 44.4811 152.91 44.4811C153.73 44.4811 154.377 44.2978 154.851 43.9311C155.326 43.5429 155.563 43.0146 155.563 42.346C155.563 41.7853 155.369 41.3216 154.981 40.955C154.614 40.5883 154.15 40.2864 153.59 40.0492C153.05 39.8119 152.274 39.5424 151.26 39.2404C149.794 38.7875 148.597 38.3347 147.67 37.8818C146.742 37.4289 145.944 36.7603 145.276 35.8761C144.607 34.9919 144.273 33.8381 144.273 32.4147C144.273 30.3012 145.039 28.6513 146.57 27.4652C148.101 26.2575 150.096 25.6536 152.554 25.6536C155.056 25.6536 157.073 26.2575 158.604 27.4652C160.135 28.6513 160.955 30.312 161.062 32.447H155.078C155.035 31.7138 154.765 31.1423 154.269 30.7325C153.773 30.3012 153.137 30.0855 152.36 30.0855C151.692 30.0855 151.153 30.2688 150.743 30.6354C150.333 30.9805 150.128 31.4873 150.128 32.1559C150.128 32.8891 150.473 33.4606 151.163 33.8704C151.854 34.2802 152.932 34.7223 154.398 35.1967C155.865 35.6928 157.051 36.1672 157.957 36.6201C158.884 37.073 159.682 37.7308 160.351 38.5934C161.019 39.4561 161.354 40.5668 161.354 41.9255C161.354 43.2194 161.019 44.3948 160.351 45.4516C159.704 46.5083 158.755 47.3494 157.504 47.9748C156.253 48.6003 154.776 48.913 153.072 48.913Z"
                  fill="black" />
                <path class="pos_text_color"
                  d="M188.142 32.7382C188.142 34.6144 187.496 36.178 186.202 37.4289C184.929 38.6581 182.977 39.2728 180.346 39.2728H176.011V48.6865H173.068V26.1389H180.346C182.891 26.1389 184.821 26.7535 186.137 27.9828C187.474 29.2121 188.142 30.7972 188.142 32.7382ZM180.346 36.8466C181.985 36.8466 183.193 36.4907 183.969 35.779C184.746 35.0673 185.134 34.0537 185.134 32.7382C185.134 29.9561 183.538 28.5651 180.346 28.5651H176.011V36.8466H180.346ZM202.024 48.913C199.932 48.913 198.023 48.4277 196.298 47.4572C194.573 46.4652 193.203 45.0957 192.189 43.3488C191.197 41.5804 190.701 39.5963 190.701 37.3965C190.701 35.1967 191.197 33.2234 192.189 31.4765C193.203 29.7081 194.573 28.3386 196.298 27.3681C198.023 26.3761 199.932 25.8801 202.024 25.8801C204.137 25.8801 206.057 26.3761 207.782 27.3681C209.507 28.3386 210.866 29.6973 211.858 31.4442C212.85 33.1911 213.346 35.1752 213.346 37.3965C213.346 39.6179 212.85 41.602 211.858 43.3488C210.866 45.0957 209.507 46.4652 207.782 47.4572C206.057 48.4277 204.137 48.913 202.024 48.913ZM202.024 46.3574C203.598 46.3574 205.011 45.9907 206.262 45.2575C207.534 44.5242 208.526 43.4782 209.238 42.1196C209.971 40.7609 210.338 39.1865 210.338 37.3965C210.338 35.5849 209.971 34.0106 209.238 32.6735C208.526 31.3148 207.545 30.2688 206.294 29.5356C205.043 28.8023 203.62 28.4357 202.024 28.4357C200.428 28.4357 199.004 28.8023 197.754 29.5356C196.503 30.2688 195.511 31.3148 194.777 32.6735C194.066 34.0106 193.71 35.5849 193.71 37.3965C193.71 39.1865 194.066 40.7609 194.777 42.1196C195.511 43.4782 196.503 44.5242 197.754 45.2575C199.026 45.9907 200.449 46.3574 202.024 46.3574ZM224.382 48.913C222.894 48.913 221.556 48.6542 220.37 48.1366C219.206 47.5974 218.289 46.8642 217.621 45.9368C216.952 44.9879 216.607 43.8988 216.585 42.6695H219.723C219.831 43.7263 220.262 44.6213 221.017 45.3545C221.794 46.0662 222.915 46.4221 224.382 46.4221C225.783 46.4221 226.883 46.077 227.681 45.3869C228.501 44.6752 228.911 43.7694 228.911 42.6695C228.911 41.8068 228.673 41.1059 228.199 40.5668C227.724 40.0276 227.131 39.6179 226.42 39.3375C225.708 39.0571 224.748 38.7552 223.541 38.4317C222.052 38.0435 220.856 37.6553 219.95 37.2671C219.066 36.8789 218.3 36.2751 217.653 35.4555C217.027 34.6144 216.715 33.493 216.715 32.0912C216.715 30.8619 217.027 29.7728 217.653 28.8239C218.278 27.8749 219.152 27.1417 220.273 26.6241C221.416 26.1065 222.721 25.8477 224.188 25.8477C226.301 25.8477 228.026 26.3761 229.363 27.4328C230.722 28.4896 231.488 29.8914 231.66 31.6383H228.425C228.317 30.7756 227.865 30.0208 227.067 29.3738C226.269 28.7053 225.212 28.371 223.896 28.371C222.667 28.371 221.664 28.6945 220.888 29.3415C220.111 29.9669 219.723 30.8511 219.723 31.9941C219.723 32.8137 219.95 33.4822 220.403 33.9998C220.877 34.5174 221.449 34.9164 222.117 35.1967C222.807 35.4555 223.767 35.7575 224.996 36.1025C226.484 36.5123 227.681 36.9221 228.587 37.3318C229.493 37.72 230.269 38.3347 230.916 39.1757C231.563 39.9953 231.887 41.1167 231.887 42.5401C231.887 43.64 231.596 44.6752 231.013 45.6457C230.431 46.6161 229.568 47.4033 228.425 48.0072C227.282 48.611 225.934 48.913 224.382 48.913Z"
                  fill="#008AEE" />
                <defs>
                  <linearGradient id="paint0_linear_217_2180" x1="1.17102" y1="10.3408" x2="36.6747" y2="61.3559"
                    gradientUnits="userSpaceOnUse">
                    <stop stop-color="#008AEE" />
                    <stop offset="1" stop-color="#004F88" />
                  </linearGradient>
                  <linearGradient id="paint1_linear_217_2180" x1="0.11377" y1="62.1488" x2="54.4845" y2="62.1488"
                    gradientUnits="userSpaceOnUse">
                    <stop stop-color="#008AEE" />
                    <stop offset="1" stop-color="#004F88" />
                  </linearGradient>
                </defs>
              </svg>

            </div>
            <div class="profile">
              <button class="light-mode-button" aria-label="Toggle Light Mode" onclick="toggle_light_mode()">
                <span></span>
                <span></span>
              </button>
              <div class="fullscreen">
                <button class="js-toggle-fullscreen-btn toggle-fullscreen-btn" aria-label="Enter fullscreen mode"
                  hidden>
                  <svg width="27" height="27" class="toggle-fullscreen-svg" viewBox="0 0 30 30" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <g class="icon-fullscreen-enter">
                      <path
                        d="M2 7.5H0V3C0 2.20435 0.31607 1.44129 0.87868 0.87868C1.44129 0.31607 2.20435 0 3 0H7.5V2H2V7.5Z"
                        fill="#192045" />
                      <path
                        d="M30 7.5H28V2H22.5V0H27C27.7956 0 28.5587 0.31607 29.1213 0.87868C29.6839 1.44129 30 2.20435 30 3V7.5Z"
                        fill="#192045" />
                      <path
                        d="M7.5 30H3C2.20435 30 1.44129 29.6839 0.87868 29.1213C0.31607 28.5587 0 27.7956 0 27V22.5H2V28H7.5V30Z"
                        fill="#192045" />
                      <path
                        d="M27 30H22.5V28H28V22.5H30V27C30 27.7956 29.6839 28.5587 29.1213 29.1213C28.5587 29.6839 27.7956 30 27 30Z"
                        fill="#192045" />
                      <path
                        d="M9.00052 10.5C8.80311 10.5011 8.60742 10.4633 8.42466 10.3887C8.24191 10.314 8.07568 10.204 7.93552 10.065L6.43552 8.565C6.15307 8.28255 5.99438 7.89946 5.99438 7.5C5.99438 7.10055 6.15307 6.71746 6.43552 6.435C6.71798 6.15255 7.10107 5.99387 7.50052 5.99387C7.89998 5.99387 8.28307 6.15255 8.56552 6.435L10.0655 7.935C10.2061 8.07445 10.3177 8.24035 10.3939 8.42314C10.47 8.60593 10.5092 8.80199 10.5092 9C10.5092 9.19802 10.47 9.39408 10.3939 9.57687C10.3177 9.75966 10.2061 9.92556 10.0655 10.065C9.92536 10.204 9.75914 10.314 9.57638 10.3887C9.39363 10.4633 9.19793 10.5011 9.00052 10.5Z"
                        fill="#192045" />
                      <path
                        d="M20.9995 10.5C20.8021 10.5011 20.6064 10.4633 20.4237 10.3887C20.2409 10.314 20.0747 10.204 19.9345 10.065C19.7939 9.92556 19.6824 9.75966 19.6062 9.57687C19.5301 9.39408 19.4908 9.19802 19.4908 9C19.4908 8.80199 19.5301 8.60593 19.6062 8.42314C19.6824 8.24035 19.7939 8.07445 19.9345 7.935L21.4345 6.435C21.717 6.15255 22.1001 5.99387 22.4995 5.99387C22.899 5.99387 23.2821 6.15255 23.5645 6.435C23.847 6.71746 24.0057 7.10055 24.0057 7.5C24.0057 7.89946 23.847 8.28255 23.5645 8.565L22.0645 10.065C21.9244 10.204 21.7582 10.314 21.5754 10.3887C21.3926 10.4633 21.197 10.5011 20.9995 10.5Z"
                        fill="#192045" />
                      <path
                        d="M7.49991 24C7.3025 24.0011 7.10681 23.9633 6.92405 23.8887C6.74129 23.814 6.57507 23.704 6.43491 23.565C6.29432 23.4256 6.18272 23.2597 6.10657 23.0769C6.03042 22.8941 5.99121 22.698 5.99121 22.5C5.99121 22.302 6.03042 22.1059 6.10657 21.9231C6.18272 21.7403 6.29432 21.5744 6.43491 21.435L7.93491 19.935C8.21736 19.6525 8.60046 19.4939 8.99991 19.4939C9.39936 19.4939 9.78245 19.6525 10.0649 19.935C10.3474 20.2175 10.506 20.6006 10.506 21C10.506 21.3995 10.3474 21.7825 10.0649 22.065L8.56491 23.565C8.42475 23.704 8.25852 23.814 8.07577 23.8887C7.89301 23.9633 7.69732 24.0011 7.49991 24Z"
                        fill="#192045" />
                      <path
                        d="M22.5 24C22.3026 24.0011 22.1069 23.9633 21.9242 23.8887C21.7414 23.814 21.5752 23.704 21.435 23.565L19.935 22.065C19.6526 21.7825 19.4939 21.3995 19.4939 21C19.4939 20.8022 19.5329 20.6064 19.6085 20.4236C19.6842 20.2409 19.7952 20.0749 19.935 19.935C20.0749 19.7951 20.2409 19.6842 20.4237 19.6085C20.6064 19.5328 20.8022 19.4939 21 19.4939C21.3995 19.4939 21.7826 19.6525 22.065 19.935L23.565 21.435C23.7056 21.5744 23.8172 21.7403 23.8934 21.9231C23.9695 22.1059 24.0087 22.302 24.0087 22.5C24.0087 22.698 23.9695 22.8941 23.8934 23.0769C23.8172 23.2597 23.7056 23.4256 23.565 23.565C23.4249 23.704 23.2587 23.814 23.0759 23.8887C22.8931 23.9633 22.6974 24.0011 22.5 24Z"
                        fill="#192045" />
                    </g>
                    <g class="icon-fullscreen-leave">
                      <path
                        d="M9.00052 10.5C8.80311 10.5011 8.60742 10.4633 8.42466 10.3887C8.24191 10.314 8.07568 10.204 7.93552 10.065L6.43552 8.565C6.15307 8.28255 5.99438 7.89946 5.99438 7.5C5.99438 7.10055 6.15307 6.71746 6.43552 6.435C6.71798 6.15255 7.10107 5.99387 7.50052 5.99387C7.89998 5.99387 8.28307 6.15255 8.56552 6.435L10.0655 7.935C10.2061 8.07445 10.3177 8.24035 10.3939 8.42314C10.47 8.60593 10.5092 8.80199 10.5092 9C10.5092 9.19802 10.47 9.39408 10.3939 9.57687C10.3177 9.75966 10.2061 9.92556 10.0655 10.065C9.92536 10.204 9.75914 10.314 9.57638 10.3887C9.39363 10.4633 9.19793 10.5011 9.00052 10.5Z"
                        fill="#192045" />
                      <path
                        d="M20.9995 10.5C20.8021 10.5011 20.6064 10.4633 20.4237 10.3887C20.2409 10.314 20.0747 10.204 19.9345 10.065C19.7939 9.92556 19.6824 9.75966 19.6062 9.57687C19.5301 9.39408 19.4908 9.19802 19.4908 9C19.4908 8.80199 19.5301 8.60593 19.6062 8.42314C19.6824 8.24035 19.7939 8.07445 19.9345 7.935L21.4345 6.435C21.717 6.15255 22.1001 5.99387 22.4995 5.99387C22.899 5.99387 23.2821 6.15255 23.5645 6.435C23.847 6.71746 24.0057 7.10055 24.0057 7.5C24.0057 7.89946 23.847 8.28255 23.5645 8.565L22.0645 10.065C21.9244 10.204 21.7582 10.314 21.5754 10.3887C21.3926 10.4633 21.197 10.5011 20.9995 10.5Z"
                        fill="#192045" />
                      <path
                        d="M7.49991 24C7.3025 24.0011 7.10681 23.9633 6.92405 23.8887C6.74129 23.814 6.57507 23.704 6.43491 23.565C6.29432 23.4256 6.18272 23.2597 6.10657 23.0769C6.03042 22.8941 5.99121 22.698 5.99121 22.5C5.99121 22.302 6.03042 22.1059 6.10657 21.9231C6.18272 21.7403 6.29432 21.5744 6.43491 21.435L7.93491 19.935C8.21736 19.6525 8.60046 19.4939 8.99991 19.4939C9.39936 19.4939 9.78245 19.6525 10.0649 19.935C10.3474 20.2175 10.506 20.6006 10.506 21C10.506 21.3995 10.3474 21.7825 10.0649 22.065L8.56491 23.565C8.42475 23.704 8.25852 23.814 8.07577 23.8887C7.89301 23.9633 7.69732 24.0011 7.49991 24Z"
                        fill="#192045" />
                      <path
                        d="M22.5 24C22.3026 24.0011 22.1069 23.9633 21.9242 23.8887C21.7414 23.814 21.5752 23.704 21.435 23.565L19.935 22.065C19.6526 21.7825 19.4939 21.3995 19.4939 21C19.4939 20.8022 19.5329 20.6064 19.6085 20.4236C19.6842 20.2409 19.7952 20.0749 19.935 19.935C20.0749 19.7951 20.2409 19.6842 20.4237 19.6085C20.6064 19.5328 20.8022 19.4939 21 19.4939C21.3995 19.4939 21.7826 19.6525 22.065 19.935L23.565 21.435C23.7056 21.5744 23.8172 21.7403 23.8934 21.9231C23.9695 22.1059 24.0087 22.302 24.0087 22.5C24.0087 22.698 23.9695 22.8941 23.8934 23.0769C23.8172 23.2597 23.7056 23.4256 23.565 23.565C23.4249 23.704 23.2587 23.814 23.0759 23.8887C22.8931 23.9633 22.6974 24.0011 22.5 24Z"
                        fill="#192045" />
                    </g>
                  </svg>
                </button>
              </div>
              <div class="profile-wrapper">
                <button type="button" class="btn header-item user text-start d-flex align-items-center"
                  id="page-header-user-dropdown-v" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <img class="rounded-circle header-profile-user" src="assets/img/navbar-profile-logo.png"
                    alt="Header Avatar" />
                </button>
                <div class="dropdown-menu dropdown-menu-end pt-0 profile-dropdown">
                  <div class="p-3 border-bottom">
                    <h6 class="mb-0">Martin Gurley</h6>
                    <a href="# " class="mb-0 font-size-11 text-muted">
                      martin.gurley@email.com
                    </a>
                  </div>
                  <a class="dropdown-item" href="contacts-profile.html"><i
                      class="mdi mdi-account-circle text-muted font-size-16 align-middle me-2"></i>
                    <span class="align-middle">Profile</span></a>
                  <a class="dropdown-item" href="apps-chat.html"><i
                      class="mdi mdi-message-text-outline text-muted font-size-16 align-middle me-2"></i>
                    <span class="align-middle">Messages</span></a>
                  <a class="dropdown-item" href="pages-faqs.html"><i
                      class="mdi mdi-lifebuoy text-muted font-size-16 align-middle me-2"></i>
                    <span class="align-middle">Help</span></a>
                  <a class="dropdown-item d-flex align-items-center" href="#"><i
                      class="mdi mdi-cog-outline text-muted font-size-16 align-middle me-2"></i>
                    <span class="align-middle me-3">Settings</span><span
                      class="badge badge-soft-success ms-auto">New</span></a>
                  <a class="dropdown-item" href="auth-lock-screen.html"><i
                      class="mdi mdi-lock text-muted font-size-16 align-middle me-2"></i>
                    <span class="align-middle">Lock screen</span></a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="auth-logout.html"><i
                      class="mdi mdi-logout text-muted font-size-16 align-middle me-2"></i>
                    <span class="align-middle">Logout</span></a>
                </div>
              </div>
            </div>
          </div>
        </nav>
        <!-- Navbar End -->

        <!-- Catgaroies Search Start -->
        <div class="catagories-search-wrapper">
          <div class="headding">
            <h1>Categories</h1>
            <p>Select From Below Categories</p>
          </div>
          <div class="searchbar">
            <label for="text">
              <input type="text" placeholder="Search product code or name..." />
              <a href="#" class="search-icon">
                <svg width="23" height="24" viewBox="0 0 27 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M19.2967 16.9811H18.0695L17.6449 16.5566C19.1578 14.8045 20.0686 12.5274 20.0686 10.0343C20.0686 4.49228 15.5763 0 10.0343 0C4.49228 0 0 4.49228 0 10.0343C0 15.5763 4.49228 20.0686 10.0343 20.0686C12.5274 20.0686 14.8045 19.1578 16.5566 17.6527L16.9811 18.0772V19.2967L24.6998 27L27 24.6998L19.2967 16.9811ZM10.0343 16.9811C6.19811 16.9811 3.08748 13.8705 3.08748 10.0343C3.08748 6.19811 6.19811 3.08748 10.0343 3.08748C13.8705 3.08748 16.9811 6.19811 16.9811 10.0343C16.9811 13.8705 13.8705 16.9811 10.0343 16.9811Z"
                    fill="white" />
                </svg>
              </a>
            </label>
          </div>
        </div>
        <!-- Catgaroies Search End -->

        <!-- Pos Product Slider Start -->
        <section id="product-slider">
          <div class="swiper-container">
            <div class="swiper-wrapper">
              <div class="swiper-slide">
                <a href="#">
                  <div class="slider-item">
                    <div class="product-img">
                      <img src="./assets/img/slider-product-img1.png" alt="" />
                    </div>
                    <div class="shadow"></div>
                  </div>
                </a>
                <div class="title">
                  <h1>ALL PRODUCTS</h1>
                </div>
              </div>
              <div class="swiper-slide">
                <a href="#">
                  <div class="slider-item">
                    <div class="product-img">
                      <img src="./assets/img/slider-product-img2.png" alt="" />
                    </div>
                    <div class="shadow"></div>
                  </div>
                </a>
                <div class="title">
                  <h1>LAPTOPS</h1>
                </div>
              </div>
              <div class="swiper-slide">
                <a href="#">
                  <div class="slider-item">
                    <div class="product-img">
                      <img src="./assets/img/slider-product-img3.png" alt="" />
                    </div>
                    <div class="shadow"></div>
                  </div>
                </a>
                <div class="title">
                  <h1>PHONES</h1>
                </div>
              </div>
              <div class="swiper-slide">
                <a href="#">
                  <div class="slider-item">
                    <div class="product-img">
                      <img src="./assets/img/slider-product-img4.png" alt="" />
                    </div>
                    <div class="shadow"></div>
                  </div>
                </a>
                <div class="title">
                  <h1>HEADPHONES</h1>
                </div>
              </div>
              <div class="swiper-slide">
                <a href="#">
                  <div class="slider-item">
                    <div class="product-img">
                      <img src="./assets/img/slider-product-img5.png" alt="" />
                    </div>
                    <div class="shadow"></div>
                  </div>
                </a>
                <div class="title">
                  <h1>SHOES</h1>
                </div>
              </div>
              <div class="swiper-slide">
                <a href="#">
                  <div class="slider-item">
                    <div class="product-img">
                      <img src="./assets/img/slider-product-img6.png" alt="" />
                    </div>
                    <div class="shadow"></div>
                  </div>
                </a>
                <div class="title">
                  <h1>WATCHES</h1>
                </div>
              </div>
              <div class="swiper-slide">
                <a href="#">
                  <div class="slider-item">
                    <div class="product-img">
                      <img src="./assets/img/slider-product-img7.png" alt="" />
                    </div>
                    <div class="shadow"></div>
                  </div>
                </a>
                <div class="title">
                  <h1>OILS</h1>
                </div>
              </div>
              <div class="swiper-slide">
                <a href="#">
                  <div class="slider-item">
                    <div class="product-img">
                      <img src="./assets/img/slider-product-img2.png" alt="" />
                    </div>
                    <div class="shadow"></div>
                  </div>
                </a>
                <div class="title">
                  <h1>LAPTOPS</h1>
                </div>
              </div>
              <!-- Add more slides as needed -->
            </div>
          </div>

          <div class="swiper-button-next">
            <i class="fa-solid fa-angle-right"></i>
          </div>
          <div class="swiper-button-prev">
            <i class="fa-solid fa-angle-left"></i>
          </div>
        </section>
        <!-- Pos Product Slider End -->

        <!-- Pos Product Card Start -->
        <section id="product-card">
          <div class="row">
            <div class="col-xl-2 col-md-4 col-4 d-flex align-items-stretch">
              <div class="card-wrapper">
                <div class="product-price">
                  <h1>$1500</h1>
                  <span>20 pcs</span>
                </div>
                <div class="product">
                  <img src="./assets/img/product-img1.png" alt="" />
                </div>
                <div class="drescription">
                  <h1 class="product-id">#01470</h1>
                  <h2 class="name">Dell XPS 13-9350</h2>
                </div>
              </div>
            </div>

            <div class="col-xl-2 col-md-4 col-4 d-flex align-items-stretch">
              <div class="card-wrapper">
                <div class="product-price">
                  <h1>$699</h1>
                  <span>120 pcs</span>
                </div>
                <div class="product">
                  <img src="./assets/img/product-img2.png" alt="" />
                </div>
                <div class="drescription">
                  <h1 class="product-id">#01480</h1>
                  <h2 class="name">Iphone 14</h2>
                </div>
              </div>
            </div>

            <div class="col-xl-2 col-md-4 col-4 d-flex align-items-stretch">
              <div class="card-wrapper">
                <div class="product-price">
                  <h1>$140</h1>
                  <span>250 pcs</span>
                </div>
                <div class="product">
                  <img src="./assets/img/product-img3.png" alt="" />
                </div>
                <div class="drescription">
                  <h1 class="product-id">#01490</h1>
                  <h2 class="name">Nike Pegasus FlyEase</h2>
                </div>
              </div>
            </div>

            <div class="col-xl-2 col-md-4 col-4 d-flex align-items-stretch">
              <div class="card-wrapper">
                <div class="product-price">
                  <h1>$850</h1>
                  <span>30 pcs</span>
                </div>
                <div class="product">
                  <img src="./assets/img/product-img4.png" alt="" />
                </div>
                <div class="drescription">
                  <h1 class="product-id">#01500</h1>
                  <h2 class="name">Hamilton</h2>
                </div>
              </div>
            </div>

            <div class="col-xl-2 col-md-4 col-4 d-flex align-items-stretch">
              <div class="card-wrapper">
                <div class="product-price">
                  <h1>$80</h1>
                  <span>120 pcs</span>
                </div>
                <div class="product">
                  <img src="./assets/img/product-img5.png" alt="" />
                </div>
                <div class="drescription">
                  <h1 class="product-id">#01510</h1>
                  <h2 class="name">SOL REPUBLIC Shadow</h2>
                </div>
              </div>
            </div>

            <div class="col-xl-2 col-md-4 col-4 d-flex align-items-stretch">
              <div class="card-wrapper">
                <div class="product-price">
                  <h1>$49</h1>
                  <span>20 Packs</span>
                </div>
                <div class="product">
                  <img src="./assets/img/product-img6.png" alt="" />
                </div>
                <div class="drescription">
                  <h1 class="product-id">#01520</h1>
                  <h2 class="name">Hershey's Kisses Chocolate</h2>
                </div>
              </div>
            </div>

            <div class="col-xl-2 col-md-4 col-4 d-flex align-items-stretch">
              <div class="card-wrapper">
                <div class="product-price">
                  <h1>$120</h1>
                  <span>260 Ltr</span>
                </div>
                <div class="product">
                  <img src="./assets/img/product-img7.png" alt="" />
                </div>
                <div class="drescription">
                  <h1 class="product-id">#01530</h1>
                  <h2 class="name">Cooking Oil- 3Ltr</h2>
                </div>
              </div>
            </div>

            <div class="col-xl-2 col-md-4 col-4 d-flex align-items-stretch">
              <div class="card-wrapper">
                <div class="product-price">
                  <h1>$15.99</h1>
                  <span>30 packs</span>
                </div>
                <div class="product">
                  <img src="./assets/img/product-img8.png" alt="" />
                </div>
                <div class="drescription">
                  <h1 class="product-id">#01540</h1>
                  <h2 class="name">Biryani Masala</h2>
                </div>
              </div>
            </div>

            <div class="col-xl-2 col-md-4 col-4 d-flex align-items-stretch">
              <div class="card-wrapper">
                <div class="product-price">
                  <h1>$250</h1>
                  <span>49 pcs</span>
                </div>
                <div class="product">
                  <img src="./assets/img/product-img9.png" alt="" />
                </div>
                <div class="drescription">
                  <h1 class="product-id">#01550</h1>
                  <h2 class="name">Phoenix Axe Body Spray</h2>
                </div>
              </div>
            </div>

            <div class="col-xl-2 col-md-4 col-4 d-flex align-items-stretch">
              <div class="card-wrapper">
                <div class="product-price">
                  <h1>$120</h1>
                  <span>36 pcs</span>
                </div>
                <div class="product">
                  <img src="./assets/img/product-img10.png" alt="" />
                </div>
                <div class="drescription">
                  <h1 class="product-id">#01560</h1>
                  <h2 class="name">Head & Shoulders Shampoo</h2>
                </div>
              </div>
            </div>

            <div class="col-xl-2 col-md-4 col-4 d-flex align-items-stretch">
              <div class="card-wrapper">
                <div class="product-price">
                  <h1>$890</h1>
                  <span>30 pcs</span>
                </div>
                <div class="product">
                  <img src="./assets/img/product-img11.png" alt="" />
                </div>
                <div class="drescription">
                  <h1 class="product-id">#01570</h1>
                  <h2 class="name">DJI Mavic Mini 2</h2>
                </div>
              </div>
            </div>

            <div class="col-xl-2 col-md-4 col-4 d-flex align-items-stretch">
              <div class="card-wrapper">
                <div class="product-price">
                  <h1>$890</h1>
                  <span>30 pcs</span>
                </div>
                <div class="product">
                  <img src="./assets/img/product-img12.png" alt="" />
                </div>
                <div class="drescription">
                  <h1 class="product-id">#01580</h1>
                  <h2 class="name">Table Nightstand Light LED Lamp</h2>
                </div>
              </div>
            </div>

            <div class="col-xl-2 col-md-4 col-4 d-flex align-items-stretch">
              <div class="card-wrapper">
                <div class="product-price">
                  <h1>$120</h1>
                  <span>260 Ltr</span>
                </div>
                <div class="product">
                  <img src="./assets/img/product-img7.png" alt="" />
                </div>
                <div class="drescription">
                  <h1 class="product-id">#01530</h1>
                  <h2 class="name">Cooking Oil- 3Ltr</h2>
                </div>
              </div>
            </div>

            <div class="col-xl-2 col-md-4 col-4 d-flex align-items-stretch">
              <div class="card-wrapper">
                <div class="product-price">
                  <h1>$15.99</h1>
                  <span>30 packs</span>
                </div>
                <div class="product">
                  <img src="./assets/img/product-img8.png" alt="" />
                </div>
                <div class="drescription">
                  <h1 class="product-id">#01540</h1>
                  <h2 class="name">Biryani Masala</h2>
                </div>
              </div>
            </div>

            <div class="col-xl-2 col-md-4 col-4 d-flex align-items-stretch">
              <div class="card-wrapper">
                <div class="product-price">
                  <h1>$250</h1>
                  <span>49 pcs</span>
                </div>
                <div class="product">
                  <img src="./assets/img/product-img9.png" alt="" />
                </div>
                <div class="drescription">
                  <h1 class="product-id">#01550</h1>
                  <h2 class="name">Phoenix Axe Body Spray</h2>
                </div>
              </div>
            </div>

            <div class="col-xl-2 col-md-4 col-4 d-flex align-items-stretch">
              <div class="card-wrapper">
                <div class="product-price">
                  <h1>$120</h1>
                  <span>36 pcs</span>
                </div>
                <div class="product">
                  <img src="./assets/img/product-img10.png" alt="" />
                </div>
                <div class="drescription">
                  <h1 class="product-id">#01560</h1>
                  <h2 class="name">Head & Shoulders Shampoo</h2>
                </div>
              </div>
            </div>

            <div class="col-xl-2 col-md-4 col-4 d-flex align-items-stretch">
              <div class="card-wrapper">
                <div class="product-price">
                  <h1>$890</h1>
                  <span>30 pcs</span>
                </div>
                <div class="product">
                  <img src="./assets/img/product-img11.png" alt="" />
                </div>
                <div class="drescription">
                  <h1 class="product-id">#01570</h1>
                  <h2 class="name">DJI Mavic Mini 2</h2>
                </div>
              </div>
            </div>

            <div class="col-xl-2 col-md-4 col-4 d-flex align-items-stretch">
              <div class="card-wrapper">
                <div class="product-price">
                  <h1>$890</h1>
                  <span>30 pcs</span>
                </div>
                <div class="product">
                  <img src="./assets/img/product-img12.png" alt="" />
                </div>
                <div class="drescription">
                  <h1 class="product-id">#01580</h1>
                  <h2 class="name">Table Nightstand Light LED Lamp</h2>
                </div>
              </div>
            </div>

            <div class="col-xl-2 col-md-4 col-4 d-flex align-items-stretch">
              <div class="card-wrapper">
                <div class="product-price">
                  <h1>$120</h1>
                  <span>260 Ltr</span>
                </div>
                <div class="product">
                  <img src="./assets/img/product-img7.png" alt="" />
                </div>
                <div class="drescription">
                  <h1 class="product-id">#01530</h1>
                  <h2 class="name">Cooking Oil- 3Ltr</h2>
                </div>
              </div>
            </div>

            <div class="col-xl-2 col-md-4 col-4 d-flex align-items-stretch">
              <div class="card-wrapper">
                <div class="product-price">
                  <h1>$15.99</h1>
                  <span>30 packs</span>
                </div>
                <div class="product">
                  <img src="./assets/img/product-img8.png" alt="" />
                </div>
                <div class="drescription">
                  <h1 class="product-id">#01540</h1>
                  <h2 class="name">Biryani Masala</h2>
                </div>
              </div>
            </div>

            <div class="col-xl-2 col-md-4 col-4 d-flex align-items-stretch">
              <div class="card-wrapper">
                <div class="product-price">
                  <h1>$250</h1>
                  <span>49 pcs</span>
                </div>
                <div class="product">
                  <img src="./assets/img/product-img9.png" alt="" />
                </div>
                <div class="drescription">
                  <h1 class="product-id">#01550</h1>
                  <h2 class="name">Phoenix Axe Body Spray</h2>
                </div>
              </div>
            </div>

            <div class="col-xl-2 col-md-4 col-4 d-flex align-items-stretch">
              <div class="card-wrapper">
                <div class="product-price">
                  <h1>$120</h1>
                  <span>36 pcs</span>
                </div>
                <div class="product">
                  <img src="./assets/img/product-img10.png" alt="" />
                </div>
                <div class="drescription">
                  <h1 class="product-id">#01560</h1>
                  <h2 class="name">Head & Shoulders Shampoo</h2>
                </div>
              </div>
            </div>

            <div class="col-xl-2 col-md-4 col-4 d-flex align-items-stretch">
              <div class="card-wrapper">
                <div class="product-price">
                  <h1>$890</h1>
                  <span>30 pcs</span>
                </div>
                <div class="product">
                  <img src="./assets/img/product-img11.png" alt="" />
                </div>
                <div class="drescription">
                  <h1 class="product-id">#01570</h1>
                  <h2 class="name">DJI Mavic Mini 2</h2>
                </div>
              </div>
            </div>

            <div class="col-xl-2 col-md-4 col-4 d-flex align-items-stretch">
              <div class="card-wrapper">
                <div class="product-price">
                  <h1>$890</h1>
                  <span>30 pcs</span>
                </div>
                <div class="product">
                  <img src="./assets/img/product-img12.png" alt="" />
                </div>
                <div class="drescription">
                  <h1 class="product-id">#01580</h1>
                  <h2 class="name">Table Nightstand Light LED Lamp</h2>
                </div>
              </div>
            </div>
          </div>
        </section>
        <!-- Pos Product Card End -->
      </div>
      <!-- Pos Catagories -->

      <!-- Pos Order List Start -->
      <div class="col-lg-5">
        <!-- Navbar Start -->
        <nav id="navbar">
          <div class="nav-wrapper">
            <div class="nav-logo">
              <img src="./assets/img/pos-nav-logo.svg" alt="" />
            </div>
            <div class="profile">
              <div class="fullscreen">
                <img src="./assets/icons/pos-navbar-full-screen.svg" alt="" />
              </div>
              <div class="profile-wrapper">
                <img src="./assets/img/navbar-profile-logo.png" alt="" />
              </div>
            </div>
          </div>
        </nav>
        <!-- Navbar End -->

        <div class="Order-list-wrapper">
          <h1 class="title">Order List</h1>
          <span class="invoice-id">Invoice No : #65565</span>
          <p>Customer Information</p>
        </div>

        <div class="select-box-wrapper">
          <label>
            <select>
              <option selected>Walk in Customer</option>
              <option>Option 1</option>
              <option>Option 2</option>
              <option>Option 3</option>
            </select>
          </label>

          <button type="button" class="add-customer-btn">
            <svg width="31" height="30" viewBox="0 0 31 30" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path
                d="M18.8066 6.6C18.8066 3 15.8066 0 12.0566 0C8.30664 0 5.30664 3 5.30664 6.6C5.30664 10.2 8.30664 13.2 12.0566 13.2C15.8066 13.2 18.8066 10.2 18.8066 6.6ZM8.30664 6.6C8.30664 4.65 9.95664 3 12.0566 3C14.1566 3 15.8066 4.65 15.8066 6.6C15.8066 8.55 14.1566 10.2 12.0566 10.2C9.95664 10.2 8.30664 8.55 8.30664 6.6Z"
                fill="white" />
              <path
                d="M0.956744 21.15L0.206744 24C-0.243256 25.35 0.056744 26.85 0.956744 28.05C1.85674 29.1 3.05674 29.7 4.55674 29.7H19.5567C20.9067 29.7 22.2567 29.1 23.0067 27.9C23.9067 26.7 24.2067 25.2 23.7567 23.85L23.0067 21C22.1067 17.25 18.8067 14.7 15.0567 14.7H9.05674C5.30674 14.7 2.00674 17.25 0.956744 21.15ZM3.05674 24.75L3.80674 21.9C4.55674 19.35 6.65674 17.7 9.05674 17.7H15.0567C17.4567 17.7 19.5567 19.35 20.3067 21.9L21.0567 24.75C21.2067 25.2 21.0567 25.8 20.7567 26.25C20.6067 26.4 20.1567 26.7 19.5567 26.7H4.55674C3.95674 26.7 3.65674 26.4 3.50674 26.1C3.05674 25.8 2.90674 25.2 3.05674 24.75Z"
                fill="white" />
              <path
                d="M30.2054 11.086H27.0734V14.29H24.1574V11.086H21.0254V8.33199H24.1574V5.10999H27.0734V8.33199H30.2054V11.086Z"
                fill="white" />
            </svg>
            ADD CUSTOMER
          </button>
        </div>
        <div class="select-box-wrapper">
          <label>
            <select>
              <option selected>Warehouse- 01</option>
              <option>Option 1</option>
              <option>Option 2</option>
              <option>Option 3</option>
            </select>
          </label>
        </div>

        <!-- Order list table Start -->
        <div class="table-wrapper">
          <div class="table">
            <table>
              <thead>
                <tr>
                  <th>Product</th>
                  <th>Price</th>
                  <th>Qty</th>
                  <th>Subtotal</th>
                  <th>Action</th>
                </tr>
              </thead>

              <tbody>
                <tr>
                  <td>
                    <div class="product">
                      <h1>ID: #01480</h1>
                      <h2>Iphone 14</h2>
                    </div>
                  </td>
                  <td>
                    <h1 class="price">$699</h1>
                  </td>
                  <td>
                    <div class="quantity-controls">
                      <button onclick="decreaseQuantity(this)">-</button>
                      <span class="quantity">1</span>
                      <button onclick="increaseQuantity(this)">+</button>
                    </div>
                  </td>
                  <td>
                    <h1 class="price">$699</h1>
                  </td>
                  <td>
                    <a href="#" class="action-btn">
                      <svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect y="0.00012207" width="44" height="44" rx="4" fill="#FFD5D5" />
                        <path
                          d="M29.4643 37.0001H14.5358C13.2262 37.0001 12.3096 35.9335 12.3096 34.7335V14.7335H31.6905V34.6001C31.6905 35.9335 30.6429 37.0001 29.4643 37.0001Z"
                          stroke="#FF0000" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round"
                          stroke-linejoin="round" />
                        <path
                          d="M33 13.9335V11.5335C33 10.6001 32.2143 9.80012 31.2976 9.80012H26.4524L25.9286 7.80012C25.6667 7.26679 25.2738 7.00012 24.619 7.00012H19.381C18.8571 7.00012 18.3333 7.26679 18.0714 7.80012L17.5476 9.66679H12.7024C11.7857 9.66679 11 10.4668 11 11.4001V13.9335C11 14.3335 11.3929 14.7335 11.7857 14.7335H32.2143C32.7381 14.7335 33 14.3335 33 13.9335Z"
                          stroke="#FF0000" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round"
                          stroke-linejoin="round" />
                        <path d="M17.8096 19.5334V32.2001" stroke="#FF0000" stroke-width="2" stroke-miterlimit="10"
                          stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M22 19.5334V32.2001" stroke="#FF0000" stroke-width="2" stroke-miterlimit="10"
                          stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M26.1904 19.5334V32.2001" stroke="#FF0000" stroke-width="2" stroke-miterlimit="10"
                          stroke-linecap="round" stroke-linejoin="round" />
                      </svg>
                    </a>
                  </td>
                </tr>
                <tr>
                  <td>
                    <div class="product">
                      <h1>ID: #01500</h1>
                      <h2>Hamilton</h2>
                    </div>
                  </td>
                  <td>
                    <h1 class="price">$850</h1>
                  </td>
                  <td>
                    <div class="quantity-controls">
                      <button onclick="decreaseQuantity(this)">-</button>
                      <span class="quantity">1</span>
                      <button onclick="increaseQuantity(this)">+</button>
                    </div>
                  </td>
                  <td>
                    <h1 class="price">$850</h1>
                  </td>
                  <td>
                    <a href="#" class="action-btn">
                      <svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect y="0.00012207" width="44" height="44" rx="4" fill="#FFD5D5" />
                        <path
                          d="M29.4643 37.0001H14.5358C13.2262 37.0001 12.3096 35.9335 12.3096 34.7335V14.7335H31.6905V34.6001C31.6905 35.9335 30.6429 37.0001 29.4643 37.0001Z"
                          stroke="#FF0000" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round"
                          stroke-linejoin="round" />
                        <path
                          d="M33 13.9335V11.5335C33 10.6001 32.2143 9.80012 31.2976 9.80012H26.4524L25.9286 7.80012C25.6667 7.26679 25.2738 7.00012 24.619 7.00012H19.381C18.8571 7.00012 18.3333 7.26679 18.0714 7.80012L17.5476 9.66679H12.7024C11.7857 9.66679 11 10.4668 11 11.4001V13.9335C11 14.3335 11.3929 14.7335 11.7857 14.7335H32.2143C32.7381 14.7335 33 14.3335 33 13.9335Z"
                          stroke="#FF0000" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round"
                          stroke-linejoin="round" />
                        <path d="M17.8096 19.5334V32.2001" stroke="#FF0000" stroke-width="2" stroke-miterlimit="10"
                          stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M22 19.5334V32.2001" stroke="#FF0000" stroke-width="2" stroke-miterlimit="10"
                          stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M26.1904 19.5334V32.2001" stroke="#FF0000" stroke-width="2" stroke-miterlimit="10"
                          stroke-linecap="round" stroke-linejoin="round" />
                      </svg>
                    </a>
                  </td>
                </tr>
                <tr>
                  <td>
                    <div class="product">
                      <h1>ID: #01550</h1>
                      <h2>Phoenix Axe Body Spray</h2>
                    </div>
                  </td>
                  <td>
                    <h1 class="price">$250</h1>
                  </td>
                  <td>
                    <div class="quantity-controls">
                      <button onclick="decreaseQuantity(this)">-</button>
                      <span class="quantity">1</span>
                      <button onclick="increaseQuantity(this)">+</button>
                    </div>
                  </td>
                  <td>
                    <h1 class="price">$250</h1>
                  </td>
                  <td>
                    <a href="#" class="action-btn">
                      <svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect y="0.00012207" width="44" height="44" rx="4" fill="#FFD5D5" />
                        <path
                          d="M29.4643 37.0001H14.5358C13.2262 37.0001 12.3096 35.9335 12.3096 34.7335V14.7335H31.6905V34.6001C31.6905 35.9335 30.6429 37.0001 29.4643 37.0001Z"
                          stroke="#FF0000" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round"
                          stroke-linejoin="round" />
                        <path
                          d="M33 13.9335V11.5335C33 10.6001 32.2143 9.80012 31.2976 9.80012H26.4524L25.9286 7.80012C25.6667 7.26679 25.2738 7.00012 24.619 7.00012H19.381C18.8571 7.00012 18.3333 7.26679 18.0714 7.80012L17.5476 9.66679H12.7024C11.7857 9.66679 11 10.4668 11 11.4001V13.9335C11 14.3335 11.3929 14.7335 11.7857 14.7335H32.2143C32.7381 14.7335 33 14.3335 33 13.9335Z"
                          stroke="#FF0000" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round"
                          stroke-linejoin="round" />
                        <path d="M17.8096 19.5334V32.2001" stroke="#FF0000" stroke-width="2" stroke-miterlimit="10"
                          stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M22 19.5334V32.2001" stroke="#FF0000" stroke-width="2" stroke-miterlimit="10"
                          stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M26.1904 19.5334V32.2001" stroke="#FF0000" stroke-width="2" stroke-miterlimit="10"
                          stroke-linecap="round" stroke-linejoin="round" />
                      </svg>
                    </a>
                  </td>
                </tr>
                <tr>
                  <td>
                    <div class="product">
                      <h1>ID: #01480</h1>
                      <h2>Iphone 14</h2>
                    </div>
                  </td>
                  <td>
                    <h1 class="price">$699</h1>
                  </td>
                  <td>
                    <div class="quantity-controls">
                      <button onclick="decreaseQuantity(this)">-</button>
                      <span class="quantity">1</span>
                      <button onclick="increaseQuantity(this)">+</button>
                    </div>
                  </td>
                  <td>
                    <h1 class="price">$699</h1>
                  </td>
                  <td>
                    <a href="#" class="action-btn">
                      <svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect y="0.00012207" width="44" height="44" rx="4" fill="#FFD5D5" />
                        <path
                          d="M29.4643 37.0001H14.5358C13.2262 37.0001 12.3096 35.9335 12.3096 34.7335V14.7335H31.6905V34.6001C31.6905 35.9335 30.6429 37.0001 29.4643 37.0001Z"
                          stroke="#FF0000" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round"
                          stroke-linejoin="round" />
                        <path
                          d="M33 13.9335V11.5335C33 10.6001 32.2143 9.80012 31.2976 9.80012H26.4524L25.9286 7.80012C25.6667 7.26679 25.2738 7.00012 24.619 7.00012H19.381C18.8571 7.00012 18.3333 7.26679 18.0714 7.80012L17.5476 9.66679H12.7024C11.7857 9.66679 11 10.4668 11 11.4001V13.9335C11 14.3335 11.3929 14.7335 11.7857 14.7335H32.2143C32.7381 14.7335 33 14.3335 33 13.9335Z"
                          stroke="#FF0000" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round"
                          stroke-linejoin="round" />
                        <path d="M17.8096 19.5334V32.2001" stroke="#FF0000" stroke-width="2" stroke-miterlimit="10"
                          stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M22 19.5334V32.2001" stroke="#FF0000" stroke-width="2" stroke-miterlimit="10"
                          stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M26.1904 19.5334V32.2001" stroke="#FF0000" stroke-width="2" stroke-miterlimit="10"
                          stroke-linecap="round" stroke-linejoin="round" />
                      </svg>
                    </a>
                  </td>
                </tr>
                <tr>
                  <td>
                    <div class="product">
                      <h1>ID: #01500</h1>
                      <h2>Hamilton</h2>
                    </div>
                  </td>
                  <td>
                    <h1 class="price">$850</h1>
                  </td>
                  <td>
                    <div class="quantity-controls">
                      <button onclick="decreaseQuantity(this)">-</button>
                      <span class="quantity">1</span>
                      <button onclick="increaseQuantity(this)">+</button>
                    </div>
                  </td>
                  <td>
                    <h1 class="price">$850</h1>
                  </td>
                  <td>
                    <a href="#" class="action-btn">
                      <svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect y="0.00012207" width="44" height="44" rx="4" fill="#FFD5D5" />
                        <path
                          d="M29.4643 37.0001H14.5358C13.2262 37.0001 12.3096 35.9335 12.3096 34.7335V14.7335H31.6905V34.6001C31.6905 35.9335 30.6429 37.0001 29.4643 37.0001Z"
                          stroke="#FF0000" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round"
                          stroke-linejoin="round" />
                        <path
                          d="M33 13.9335V11.5335C33 10.6001 32.2143 9.80012 31.2976 9.80012H26.4524L25.9286 7.80012C25.6667 7.26679 25.2738 7.00012 24.619 7.00012H19.381C18.8571 7.00012 18.3333 7.26679 18.0714 7.80012L17.5476 9.66679H12.7024C11.7857 9.66679 11 10.4668 11 11.4001V13.9335C11 14.3335 11.3929 14.7335 11.7857 14.7335H32.2143C32.7381 14.7335 33 14.3335 33 13.9335Z"
                          stroke="#FF0000" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round"
                          stroke-linejoin="round" />
                        <path d="M17.8096 19.5334V32.2001" stroke="#FF0000" stroke-width="2" stroke-miterlimit="10"
                          stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M22 19.5334V32.2001" stroke="#FF0000" stroke-width="2" stroke-miterlimit="10"
                          stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M26.1904 19.5334V32.2001" stroke="#FF0000" stroke-width="2" stroke-miterlimit="10"
                          stroke-linecap="round" stroke-linejoin="round" />
                      </svg>
                    </a>
                  </td>
                </tr>
                <tr>
                  <td>
                    <div class="product">
                      <h1>ID: #01550</h1>
                      <h2>Phoenix Axe Body Spray</h2>
                    </div>
                  </td>
                  <td>
                    <h1 class="price">$250</h1>
                  </td>
                  <td>
                    <div class="quantity-controls">
                      <button onclick="decreaseQuantity(this)">-</button>
                      <span class="quantity">1</span>
                      <button onclick="increaseQuantity(this)">+</button>
                    </div>
                  </td>
                  <td>
                    <h1 class="price">$250</h1>
                  </td>
                  <td>
                    <a href="#" class="action-btn">
                      <svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect y="0.00012207" width="44" height="44" rx="4" fill="#FFD5D5" />
                        <path
                          d="M29.4643 37.0001H14.5358C13.2262 37.0001 12.3096 35.9335 12.3096 34.7335V14.7335H31.6905V34.6001C31.6905 35.9335 30.6429 37.0001 29.4643 37.0001Z"
                          stroke="#FF0000" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round"
                          stroke-linejoin="round" />
                        <path
                          d="M33 13.9335V11.5335C33 10.6001 32.2143 9.80012 31.2976 9.80012H26.4524L25.9286 7.80012C25.6667 7.26679 25.2738 7.00012 24.619 7.00012H19.381C18.8571 7.00012 18.3333 7.26679 18.0714 7.80012L17.5476 9.66679H12.7024C11.7857 9.66679 11 10.4668 11 11.4001V13.9335C11 14.3335 11.3929 14.7335 11.7857 14.7335H32.2143C32.7381 14.7335 33 14.3335 33 13.9335Z"
                          stroke="#FF0000" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round"
                          stroke-linejoin="round" />
                        <path d="M17.8096 19.5334V32.2001" stroke="#FF0000" stroke-width="2" stroke-miterlimit="10"
                          stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M22 19.5334V32.2001" stroke="#FF0000" stroke-width="2" stroke-miterlimit="10"
                          stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M26.1904 19.5334V32.2001" stroke="#FF0000" stroke-width="2" stroke-miterlimit="10"
                          stroke-linecap="round" stroke-linejoin="round" />
                      </svg>
                    </a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <form id="orderForm">
            <div class="order-wrapper">
              <div class="input-group">
                <label for="orderTax" class="input-group-text">Order Tax</label>
                <div class="input-wrapper">
                  <input type="number" id="orderTax" name="orderTax" placeholder="00" required />
                  <span>%</span>
                </div>
              </div>
              <div class="input-group">
                <label for="shipping" class="input-group-text">Shipping</label>
                <div class="input-wrapper">
                  <input type="number" id="shipping" name="shipping" placeholder="20" required />
                  <span>$</span>
                </div>
              </div>
              <div class="input-group">
                <label for="discount" class="input-group-text">Discount</label>
                <div class="input-wrapper">
                  <input type="number" id="discount" name="discount" placeholder="03" required />
                  <span>%</span>
                </div>
              </div>
            </div>
            <div class="totals">
              <div class="subtotal">
                <span>Sub-Total</span>
                <span>$3,173.99</span>
              </div>
              <div class="total">
                <span>Total</span>
                <span>$3,135.82</span>
              </div>
            </div>
            <div class="buttons">
              <button type="button" class="reset">Reset</button>
              <button id="openModalBtn" type="submit" class="pay-now">Pay Now</button>
              <button type="button" class="draft">Draft</button>
              <button type="button" class="recent-draft">Recent Draft</button>
            </div>
          </form>
        </div>
      </div>
      <!-- Pos Order List End -->
    </div>
  </section>

  <!-- Create Payment Pop Up Modal Start -->
  <section id="myModal" class="create-payment-modal">
    <div class="modal-content">
      <span class="close-btn close">
        <i class="fa-solid fa-xmark"></i>
      </span>

      <div id="popup-modal">
        <div class="modal-wrapper">
          <div class="row">
            <!-- Product Details Start -->
            <div class="col-lg-6">
              <div class="modal-title">
                <h1>Create Payment</h1>
              </div>
              <div class="table-wrapper">
                <div class="product-details">
                  <h1>Product Details</h1>
                </div>
                <div class="table">
                  <table>
                    <thead>
                      <tr>
                        <th>SL</th>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Qty</th>
                      </tr>
                    </thead>

                    <tbody>
                      <tr>
                        <td>
                          <div class="sl-nmbr">
                            <h1>01</h1>
                          </div>
                        </td>
                        <td>
                          <h1 class="product">#01480-Iphone</h1>
                        </td>
                        <td>
                          <div class="qty">
                            <h1>1</h1>
                          </div>
                        </td>
                        <td>
                          <h1 class="price">$699</h1>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <div class="sl-nmbr">
                            <h1>02</h1>
                          </div>
                        </td>
                        <td>
                          <h1 class="product">#01500-Hamilton</h1>
                        </td>
                        <td>
                          <div class="qty">
                            <h1>1</h1>
                          </div>
                        </td>
                        <td>
                          <h1 class="price">$850</h1>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <div class="sl-nmbr">
                            <h1>03</h1>
                          </div>
                        </td>
                        <td>
                          <h1 class="product">
                            #01550-Phoenix Axe Body Spray
                          </h1>
                        </td>
                        <td>
                          <div class="qty">
                            <h1>1</h1>
                          </div>
                        </td>
                        <td>
                          <h1 class="price">$250</h1>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <div class="sl-nmbr">
                            <h1>04</h1>
                          </div>
                        </td>
                        <td>
                          <h1 class="product">#01490-Nike Pegasus FlyEase</h1>
                        </td>
                        <td>
                          <div class="qty">
                            <h1>1</h1>
                          </div>
                        </td>
                        <td>
                          <h1 class="price">$140</h1>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <div class="sl-nmbr">
                            <h1>05</h1>
                          </div>
                        </td>
                        <td>
                          <h1 class="product">#01510-SOL REPUBLIC Shadow</h1>
                        </td>
                        <td>
                          <div class="qty">
                            <h1>1</h1>
                          </div>
                        </td>
                        <td>
                          <h1 class="price">$80</h1>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <div class="sl-nmbr">
                            <h1>06</h1>
                          </div>
                        </td>
                        <td>
                          <h1 class="product">
                            #01520-Hershey's Kisses Chocolate
                          </h1>
                        </td>
                        <td>
                          <div class="qty">
                            <h1>1</h1>
                          </div>
                        </td>
                        <td>
                          <h1 class="price">$49</h1>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <div class="sl-nmbr">
                            <h1>07</h1>
                          </div>
                        </td>
                        <td>
                          <h1 class="product">#01530-Cooking Oil- 3Ltr</h1>
                        </td>
                        <td>
                          <div class="qty">
                            <h1>1</h1>
                          </div>
                        </td>
                        <td>
                          <h1 class="price">$120</h1>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <div class="sl-nmbr">
                            <h1>08</h1>
                          </div>
                        </td>
                        <td>
                          <h1 class="product">#01540-Biryani Masala</h1>
                        </td>
                        <td>
                          <div class="qty">
                            <h1>1</h1>
                          </div>
                        </td>
                        <td>
                          <h1 class="price">$15.99</h1>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <div class="sl-nmbr">
                            <h1>09</h1>
                          </div>
                        </td>
                        <td>
                          <h1 class="product">
                            #01570-Table Nightstand Light LED Lamp
                          </h1>
                        </td>
                        <td>
                          <div class="qty">
                            <h1>1</h1>
                          </div>
                        </td>
                        <td>
                          <h1 class="price">$890</h1>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <div class="sl-nmbr">
                            <h1>10</h1>
                          </div>
                        </td>
                        <td>
                          <h1 class="product">
                            #01560-Table Nightstand Light LED Lamp
                          </h1>
                        </td>
                        <td>
                          <div class="qty">
                            <h1>1</h1>
                          </div>
                        </td>
                        <td>
                          <h1 class="price">$120</h1>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <div class="sl-nmbr">
                            <h1>06</h1>
                          </div>
                        </td>
                        <td>
                          <h1 class="product">
                            #01520-Hershey's Kisses Chocolate
                          </h1>
                        </td>
                        <td>
                          <div class="qty">
                            <h1>1</h1>
                          </div>
                        </td>
                        <td>
                          <h1 class="price">$49</h1>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <div class="sl-nmbr">
                            <h1>07</h1>
                          </div>
                        </td>
                        <td>
                          <h1 class="product">#01530-Cooking Oil- 3Ltr</h1>
                        </td>
                        <td>
                          <div class="qty">
                            <h1>1</h1>
                          </div>
                        </td>
                        <td>
                          <h1 class="price">$120</h1>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <div class="sl-nmbr">
                            <h1>08</h1>
                          </div>
                        </td>
                        <td>
                          <h1 class="product">#01540-Biryani Masala</h1>
                        </td>
                        <td>
                          <div class="qty">
                            <h1>1</h1>
                          </div>
                        </td>
                        <td>
                          <h1 class="price">$15.99</h1>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <div class="sl-nmbr">
                            <h1>09</h1>
                          </div>
                        </td>
                        <td>
                          <h1 class="product">
                            #01570-Table Nightstand Light LED Lamp
                          </h1>
                        </td>
                        <td>
                          <div class="qty">
                            <h1>1</h1>
                          </div>
                        </td>
                        <td>
                          <h1 class="price">$890</h1>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <div class="sl-nmbr">
                            <h1>10</h1>
                          </div>
                        </td>
                        <td>
                          <h1 class="product">
                            #01560-Table Nightstand Light LED Lamp
                          </h1>
                        </td>
                        <td>
                          <div class="qty">
                            <h1>1</h1>
                          </div>
                        </td>
                        <td>
                          <h1 class="price">$120</h1>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>

                <form id="orderForm">
                  <div class="totals">
                    <div class="subtotal">
                      <span>Sub-Total</span>
                      <span>$3,173.99</span>
                    </div>
                    <div class="tax">
                      <span>Tax (0.00%)</span>
                      <span>$0.00</span>
                    </div>
                    <div class="discount">
                      <span>Discount (3%)</span>
                      <span>$58.17</span>
                    </div>
                    <div class="shipping-cost">
                      <span>Shipping Cost</span>
                      <span>$20.00</span>
                    </div>
                  </div>

                  <button type="button" class="pay-btn">
                    Total Payable: $3,135.82
                  </button>
                </form>
              </div>
            </div>
            <!-- Product Details End -->

            <!-- Payment Start -->
            <div class="col-lg-6">
              <div class="incoice-id">
                <h2>Invoice No. : #65565</h2>
              </div>
              <div id="payment">
                <div class="totals">
                  <div class="total-amount">
                    <span>Total Payable Amount</span>
                    <span>$3,135.82</span>
                  </div>
                  <div class="paid-amount">
                    <span>Paid Amount</span>
                    <input type="text" />
                  </div>
                  <div class="due-amount">
                    <span>Due Amount</span>
                    <span>0.00</span>
                  </div>
                  <div class="status">
                    <span>Shipping Cost</span>
                    <span class="full-paid">Full Paid</span>
                  </div>
                </div>

                <div class="payments">
                  <div class="heading">
                    <h2>Payment Method</h2>
                  </div>
                  <form action="#">
                    <input type="radio" name="payment" id="cash" />
                    <input type="radio" name="payment" id="bkash" />
                    <input type="radio" name="payment" id="nagad" />
                    <input type="radio" name="payment" id="rocket" />
                    <input type="radio" name="payment" id="bank" />
                    <input type="radio" name="payment" id="mastercard" />

                    <div class="category-wrapper">
                      <div class="category">
                        <label for="cash" class="cashMethod">
                          <input type="radio" name="payment" id="cash" />
                          <div class="imgName">
                            <div class="imgContainer cash">
                              <img src="./assets/img/payment-cash.png" alt="" />
                            </div>
                            <h1>Cash</h1>
                          </div>
                          <span class="check"><i class="fa-solid fa-circle-check"></i></span>
                        </label>


                        <label for="bkash" class="bkashMethod">
                          <div class="imgName">
                            <div class="imgContainer bkash">
                              <img src="./assets/img/payment-bkash.png" alt="" />
                            </div>
                            <h1>bKash</h1>
                          </div>
                          <span class="check"><i class="fa-solid fa-circle-check"></i></span>
                        </label>

                        <label for="nagad" class="nagadMethod">
                          <div class="imgName">
                            <div class="imgContainer nagad">
                              <img src="./assets/img/payment-nagad.png" alt="" />
                            </div>
                            <h1>Nagad</h1>
                          </div>
                          <span class="check"><i class="fa-solid fa-circle-check"></i></span>
                        </label>

                        <label for="rocket" class="rocketMethod">
                          <div class="imgName">
                            <div class="imgContainer rocket">
                              <img src="./assets/img/payment-rocket.png" alt="" />
                            </div>
                            <h1>Rocket</h1>
                          </div>
                          <span class="check"><i class="fa-solid fa-circle-check"></i></span>
                        </label>

                        <label for="bank" class="bankMethod">
                          <div class="imgName">
                            <div class="imgContainer bank">
                              <img src="./assets/img/payment-bank.png" alt="" />
                            </div>
                            <h1>Bank</h1>
                          </div>
                          <span class="check"><i class="fa-solid fa-circle-check"></i></span>
                        </label>

                        <label for="mastercard" class="mastercardMethod">
                          <div class="imgName">
                            <div class="imgContainer mastercard">
                              <img src="./assets/img/payment-card.png" alt="" />
                            </div>
                            <h1>Card</h1>
                          </div>
                          <span class="check"><i class="fa-solid fa-circle-check"></i></span>
                        </label>
                      </div>
                    </div>
                  </form>
                </div>
                <div class="transaction">
                  <input type="text" id="transactionInput" placeholder="Enter Transaction ID" />
                </div>
                <div class="submit-btn">
                  <button type="submit" class="submit">SUBMIT</button>
                </div>
              </div>
            </div>
            <!-- Payment End -->
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Create Payment Pop Up Modal End -->

  <!-- Link Swiper's JS -->
  <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

  <!-- JAVASCRIPT -->

  <script src="{{asset('backend/assets/js/fontawesome.js')}}"></script>
  <script src="{{asset('backend/assets/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('backend/assets/js/pos-product-slider.js')}}"></script>
  <script src="{{asset('backend/assets/js/orderlist-table-qty.js')}}"></script>
  <script src="{{asset('backend/assets/js/finance-popup-modal.js')}}"></script>
  <script src="{{asset('backend/assets/js/full-screen-toggle.js')}}"></script>
  <script src="{{asset('backend/assets/js/app.js')}}"></script>
  <script src="{{asset('backend/assets/js/pos-model-category-click.js')}}"></script>
</body>

</html>
