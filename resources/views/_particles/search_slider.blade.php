<div id="banner">
  <section class="count_dd">
  <div id="subheader" class="extra_space">
  </div>
  <div class="hidden-xs" id="count">
    <ul>
      <li><span class="number">{{getcong('total_restaurant')}}</span> Restaurant</li>
      <li><span class="number">{{getcong('total_people_served')}}</span> People Served</li>
      <li><span class="number">{{getcong('total_registered_users')}}</span> Registered Users</li>
    </ul>
  </div>
  </section>
    <div class="flex-banner">
      <ul class="slides">
        <li><img src="{{ URL::asset('upload/'.getcong('home_slide_image1'))}}" alt=""></li>
        <li><img src="{{ URL::asset('upload/'.getcong('home_slide_image2'))}}" alt=""></li>
        <li><img src="{{ URL::asset('upload/'.getcong('home_slide_image3'))}}" alt=""></li>
         
      </ul>
    </div>
  </div>