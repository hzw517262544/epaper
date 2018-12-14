package com.bootdo.epaper.controller;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import com.bootdo.epaper.domain.PaperDO;
import com.bootdo.epaper.domain.RectDO;
import com.bootdo.epaper.service.PaperService;
import com.bootdo.epaper.service.RectService;
import org.apache.shiro.authz.annotation.RequiresPermissions;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.ui.Model;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.bind.annotation.ResponseBody;

import com.bootdo.epaper.domain.NewsDO;
import com.bootdo.epaper.service.NewsService;
import com.bootdo.common.utils.PageUtils;
import com.bootdo.common.utils.Query;
import com.bootdo.common.utils.R;

/**
 * 
 * 
 * @author hzw
 * @email hao17681124518@163.com
 * @date 2018-12-13 19:26:44
 */
 
@Controller
@RequestMapping("/epaper/news")
public class NewsController {
	@Autowired
	private NewsService newsService;
	@Autowired
	private PaperService paperService;
	@Autowired
	private RectService rectService;

	
	@GetMapping()
//	@RequiresPermissions("epaper:news:news")
	String News(){

	    return "epaper/Admin/NewsManage";
	}
	
	@ResponseBody
	@GetMapping("/list")
//	@RequiresPermissions("epaper:news:news")
	public PageUtils list(@RequestParam Map<String, Object> params){
		//查询列表数据
        Query query = new Query(params);
		List<NewsDO> newsList = newsService.list(query);
		int total = newsService.count(query);
		PageUtils pageUtils = new PageUtils(newsList, total);
		return pageUtils;
	}
	
	@GetMapping("/add")
//	@RequiresPermissions("epaper:news:add")
	String add(Model model){
		//加载最近50期
		Map<String,Object> parMap = new HashMap<String,Object>();
		parMap.put("offset",0);
		parMap.put("limit",50);
		List<PaperDO> paperDOS = paperService.list(parMap);
		model.addAttribute("papers",paperDOS);
		List<RectDO> rectDOS = null;
		if(paperDOS!=null&&!paperDOS.isEmpty()){
			parMap.clear();
			parMap.put("publishid",paperDOS.get(0).getPublishid());
			rectDOS = rectService.list(parMap);
		}else{
			rectDOS = new ArrayList<RectDO>();
		}
		model.addAttribute("rects",rectDOS);
	    return "epaper/Admin/AddNews";
	}

	@GetMapping("/edit/{id}")
//	@RequiresPermissions("epaper:news:edit")
	String edit(@PathVariable("id") Integer id,Model model){
		NewsDO news = newsService.get(id);
		model.addAttribute("news", news);
		//加载最近50期
		Map<String,Object> parMap = new HashMap<String,Object>();
		parMap.put("offset",0);
		parMap.put("limit",50);
		List<PaperDO> paperDOS = paperService.list(parMap);
		model.addAttribute("papers",paperDOS);
		List<RectDO> rectDOS = null;
		if(paperDOS!=null&&!paperDOS.isEmpty()){
			parMap.clear();
			parMap.put("publishid",paperDOS.get(0).getPublishid());
			rectDOS = rectService.list(parMap);
			for(PaperDO paperDO : paperDOS){
				if(paperDO.getPublishdate().equals(news.getPublishdate())){
					paperDO.setSelected("true");
				}
			}
		}else{
			rectDOS = new ArrayList<RectDO>();
		}
		for(RectDO rectDO : rectDOS){
			if(rectDO.getId().equals(news.getVerorderid())){
				rectDO.setSelected("true");
			}
		}
		model.addAttribute("rects",rectDOS);
	    return "epaper/Admin/ModifyNews";
	}
	
	/**
	 * 保存
	 */
	@ResponseBody
	@PostMapping("/save")
//	@RequiresPermissions("epaper:news:add")
	public R save( NewsDO news){
		if(newsService.save(news)>0){
			return R.ok();
		}
		return R.error();
	}
	/**
	 * 修改
	 */
	@ResponseBody
	@RequestMapping("/update")
//	@RequiresPermissions("epaper:news:edit")
	public R update( NewsDO news){
		newsService.update(news);
		return R.ok();
	}
	
	/**
	 * 删除
	 */
	@PostMapping( "/remove")
	@ResponseBody
//	@RequiresPermissions("epaper:news:remove")
	public R remove( Integer id){
		if(newsService.remove(id)>0){
		return R.ok();
		}
		return R.error();
	}
	
	/**
	 * 删除
	 */
	@PostMapping( "/batchRemove")
	@ResponseBody
//	@RequiresPermissions("epaper:news:batchRemove")
	public R remove(@RequestParam("ids[]") Integer[] ids){
		newsService.batchRemove(ids);
		return R.ok();
	}
	
}
