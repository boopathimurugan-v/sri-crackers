<script type="text/babel">

const {
    useState,
    useEffect
}=React;

/*-------------------------
 Navigation Component
--------------------------*/

function NavbarMenu(){

const [mobile,setMobile]=useState(false);

useEffect(()=>{

    if(window.lucide){

        lucide.createIcons();

    }

},[mobile]);

return(

<>

<div
className="hidden lg:flex items-center gap-8 font-semibold">

<a href="/">Home</a>

<a href="/categories">Categories</a>

<a href="/combo-offers">Combo Offers</a>

<a href="/price-list">Price List</a>

<a href="/about">About Us</a>

<button
className="bg-gray-100 rounded-xl px-5 py-3 flex items-center gap-2">

<i data-lucide="search"></i>

Search

</button>

<button
className="bg-red-600 text-white rounded-xl px-6 py-3 flex items-center gap-2">

<i data-lucide="shopping-cart"></i>

Cart (0)

</button>

</div>

<div
className="lg:hidden">

<button
onClick={()=>setMobile(!mobile)}>

<i
data-lucide={mobile ? "x":"menu"}></i>

</button>

</div>

{
mobile &&

<div
className="absolute left-0 top-20 bg-white w-full shadow-lg p-5 space-y-4">

<a href="/">Home</a>

<a href="/categories">Categories</a>

<a href="/combo-offers">Combo Offers</a>

<a href="/price-list">Price List</a>

<a href="/about">About</a>

</div>

}

</>

)

}

ReactDOM
.createRoot(
document.getElementById("navbar-menu")
)
.render(<NavbarMenu/>);

/*-------------------------
 Footer Social
--------------------------*/

function FooterSocial(){

useEffect(()=>{

if(window.lucide){

lucide.createIcons();

}

},[]);

return(

<div
className="flex gap-4">

<i data-lucide="facebook"></i>

<i data-lucide="instagram"></i>

<i data-lucide="youtube"></i>

<i data-lucide="phone"></i>

</div>

)

}

ReactDOM
.createRoot(
document.getElementById("footer-social")
)
.render(<FooterSocial/>);

</script>