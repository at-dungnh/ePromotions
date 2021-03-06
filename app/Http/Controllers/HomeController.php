<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Promotion\PromotionRepository;
use App\Repositories\Product\ProductRepository;
use App\Repositories\Event\EventRepository;
use App\Repositories\User\UserRepository;
use App\Repositories\VoteProduct\VoteProductRepository;
use Session;

class HomeController extends Controller
{
    /**
     * The CategoryRepository instance
     *
     * @var CategoryRepository
     */
    protected $categoryRepository;
    /**
     * The PromotionRepository instance
     *
     * @var PromotionRepository
     */
    protected $promotionRepository;
    /**
     * The ProductRepository instance
     *
     * @var ProductRepository
     */
    protected $productRepository;
    /**
     * The EventRepository instance
     *
     * @var EventRepository
     */
    protected $eventRepository;

    /**
     * The userRepository instance
     *
     * @var userRepository
     */
    protected $userRepository;

    /**
     * The VoteProductRepository instance
     *
     * @var voteProRepository
     */
    protected $voteProRepository;

   /**
    * Create a new controller instance.
    *
    * @param CategoryRepository    $categoryRepository  [description]
    * @param PromotionRepository   $promotionRepository [description]
    * @param ProductRepository     $productRepository   [description]
    * @param EventRepository       $eventRepository     [description]
    * @param VoteProductRepository $voteProRepository   [description]
    * @param UserRepository        $userRepository      [description]
    */
    public function __construct(CategoryRepository $categoryRepository, PromotionRepository $promotionRepository, ProductRepository $productRepository, EventRepository $eventRepository, VoteProductRepository $voteProRepository, UserRepository $userRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->promotionRepository = $promotionRepository;
        $this->productRepository = $productRepository;
        $this->eventRepository = $eventRepository;
        $this->userRepository = $userRepository;
        $this->voteProRepository = $voteProRepository;
    }
    /**
     * Display information in index page
     *
     * @return Reponse
     */
    public function index()
    {
        $categories = $this->categoryRepository->allRoot();
        foreach ($categories as $key => $category) {
            $childs[$key] = $this->categoryRepository->findDescendants($category->id);
        }
        $promotionSlide= $this->promotionRepository->filterIndex();
        $promotions = $this->promotionRepository->getNeartest();
        $products = $this->productRepository->getProductTopVote();
        foreach ($products as $product) {
            $product->promotion = $this->promotionRepository->promotion($product->id);
        }
        $voteProducts = $this->voteProRepository->all();
        $arPointVote = $this->voteProRepository->getArPointVote($products, $voteProducts);
        $events = $this->eventRepository->getEventNewest();
        $flag = $this->userRepository->checkLogin();
        return view('index.index', compact('categories', 'childs', 'promotions', 'products', 'voteProducts', 'arPointVote', 'events', 'flag', 'promotionSlide'));
    }
    
    /**
    * Show list all product
    *
    * @return product page
    */
    public function product()
    {
        $categories = $this->categoryRepository->allRoot();
        foreach ($categories as $key => $category) {
            $childs[$key] = $this->categoryRepository->findDescendants($category->id);
        }
        $products = $this->productRepository->getAll()->paginate(config('constants.limit_product'));
        $voteProducts = $this->voteProRepository->all();
        $arPointVote = $this->voteProRepository->getArPointVote($products, $voteProducts);
        return view('index.product', compact('products', 'categories', 'childs', 'voteProducts', 'arPointVote'));
    }
    /**
    * Display product research
    *
    * @param Request $request [ value input tag ]
    *
    * @return [type]          [get all product event of search]
    */
    public function research(Request $request)
    {
        $cate = $request->input('category_name');
        $search = $request->input('search');
        $categories = $this->categoryRepository->allRoot();
        $voteProducts = $this->voteProRepository->all();
        foreach ($categories as $key => $category) {
            $childs[$key] = $this->categoryRepository->findDescendants($category->id);
        };
        if ($cate==config('constants.Promotion')) {
            $products = $this->productRepository->getByPromotion($search)->paginate(config('constants.limit_product'));
            $totalProduct = $this->productRepository->getByPromotion($search)->count();
            $arPointVote = $this->voteProRepository->getArPointVote($products, $voteProducts);
            return view('index.product', compact('products', 'categories', 'childs', 'totalProduct', 'search', 'voteProducts', 'arPointVote'));
        } else {
            $products = $this->productRepository->findLike('product_name', $search)->paginate(config('constants.limit_product'));
            $totalProduct = $this->productRepository->findLike('product_name', $search)->count();
            $arPointVote = $this->voteProRepository->getArPointVote($products, $voteProducts);
            return view('index.product', compact('products', 'categories', 'childs', 'totalProduct', 'search', 'voteProducts', 'arPointVote'));
        }
    }

    /**
     * [list event]
     *
     * @return [type] [list event exist in table]
     */
    public function event()
    {
        $categories = $this->categoryRepository->allRoot();
        foreach ($categories as $key => $category) {
            $childs[$key] = $this->categoryRepository->findDescendants($category->id);
        }
        $events = $this->eventRepository->getEventExist();
        return view('index.event-index', compact('categories', 'childs', 'events'));
    }
    /**
     * [get Event Detail]
     *
     * @param [type] $id [id event]
     *
     * @return [type]     [value colum event in table ]
     */
    public function eventDetail($id)
    {
        $categories = $this->categoryRepository->allRoot();
        foreach ($categories as $key => $category) {
            $childs[$key] = $this->categoryRepository->findDescendants($category->id);
        }
        $eventDetail = $this->eventRepository->find($id);
        return view('index.event-detail', compact('categories', 'childs', 'eventDetail'));
    }
}
