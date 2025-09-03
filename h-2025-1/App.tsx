import { Header } from "./components/Header";
import { Hero } from "./components/Hero";
import { JobListings } from "./components/JobListings";
import { CompanySection } from "./components/CompanySection";
import { Footer } from "./components/Footer";

export default function App() {
  return (
    <div className="min-h-screen" dir="rtl" style={{ backgroundColor: 'rgb(31, 41, 55)' }}>
      <Header />
      <Hero />
      <JobListings />
      <CompanySection />
      <Footer />
    </div>
  );
}