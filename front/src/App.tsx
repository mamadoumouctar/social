import {createBrowserRouter, RouterProvider, NavLink, Link, Outlet} from "react-router-dom"
import {Index as ArticleIndex} from "./pages/articles";
import {Index as CategorieIndex} from "./pages/categories";
import {PropsWithChildren} from "react";
import {ShowArticle} from "./components/article/show.tsx";

const router = createBrowserRouter([
    {
        path: '/',
        element: <Navigation>
            <div className="container">
                <Outlet></Outlet>
            </div>
        </Navigation>,
        children: [
            {
                path: '/article',
                element: <ArticleIndex />
            }, {
                path: '/article/:slug/:id',
                element: <ShowArticle />
            }, {
                path: '/categorie',
                element: <CategorieIndex />
            }
        ]
    }
])

function Navigation({children}: PropsWithChildren)
{
    return <div>
        <nav className="navbar navbar-expand-lg" style={{backgroundColor: "#FFE4C4FF"}}>
            <div className="container-fluid">
                <Link className="navbar-brand" to="/">TM Social Network</Link>
                <button className="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span className="navbar-toggler-icon"></span>
                </button>
                <div className="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul className="navbar-nav me-auto mb-2 mb-lg-0">
                        <li className="nav-item">
                            <NavLink className="nav-link" to="/article">Articles</NavLink>
                        </li>
                        <li className="nav-item">
                            <NavLink className="nav-link" to="/categorie">Categories</NavLink>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        {children}
    </div>
}
function App() {

  return (<>
      <RouterProvider router={router} />
    </>
  )
}

export default App
